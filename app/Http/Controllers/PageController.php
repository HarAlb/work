<?php

namespace App\Http\Controllers;

use App\User;
use App\IpRelationship;
use App\Website;

use App\Http\Requests\UrlRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index(){

        if( $user = User::where('ip_address' , request()->ip() )->first('id')){
            $all_info = $this->website_info($user->id);
        }
        return view('welcome')->with('websites' , isset($all_info) ? $all_info : "");
    }

    public function create(UrlRequest $req){
        if( $this->get_header($req->url) === 200 ){
            $cleared_url = $this->clear_url($req->url);
            $existing_info = $this->website_exists($cleared_url , $req->url);
            $user = $this->get_user_by_ip($req->ip());
            $website_id = isset($existing_info->id) ? $existing_info->id  :  $existing_info;
            $this->make_relationship( $website_id , $user->id);
            return redirect()->back();
        }
        return redirect()->back()->withInput()->withErrors(['url' => 'Site Url dosn\'t exists']);
    }

    public function redirect( $token ){
        $url = Website::where("token" , $token)->first();
        return redirect($url->website_full_url, 301);
    }

    // Helpers

    private function make_relationship( $website_id , $user_id ){
        $exists = IpRelationship::where("user_id" , $user_id)->where("website_id" , $website_id)->first();

        if(!$exists){
            IpRelationship::create([
                "user_id"    => $user_id,
                "website_id" => $website_id
            ]);
        }
    }


    private function get_user_by_ip($ip){
        $user = User::where("ip_address" , $ip )->first();
        if(!$user){
            $user = User::create([
                "ip_address" => $ip
            ]);
        }
        return $user;
    }

    private function website_exists($cleared_url , $full_url){
        $existing_info = Website::where( "website_url" , $cleared_url )->first();
        if(!$existing_info){
            $existing_info = Website::create([
                "website_title"    => $this->get_title_by_url($full_url),
                "website_url"      => $cleared_url,
                "token"            => $this->get_token(),
                "website_full_url" => $full_url
                ]);

            }else{
                $this->update_title( $existing_info->id , $this->get_title_by_url($full_url) );
            }

        return $existing_info;
    }


    private function get_token(){
        $token = Str::random(6);
        while(Website::where("token" , $token)->first()){
            $token = Str::random(6);
        }
        return $token;
    }

    private function update_title( $id , $title ){
        return Website::where("id" , $id)->update([
            "website_title" => $title
        ]);
    }

    private function get_header( $url ){
        $headers = get_headers($url);
        return intval(substr($headers[0], 9, 3));
    }


    private function get_title_by_url($url){
        $page_html = @file_get_contents($url);
        if( preg_match('/<title>(.*)<\/title>/' , $page_html , $title) ){
            return $title[1];
        };

        return "";
    }

    private function clear_url($url){
        return str_replace(["http://www." , "https://www." , "http://" , "https://"] , "" , $url);
    }

    private function website_info($id){
        $all_info = User::find($id)->relations()->with('websites')->get();
            foreach( $all_info as $one){
                foreach( $one->websites as $website){
                    $websites[] = [
                        "title"           => $website->website_title,
                        "url"             => $website->website_url,
                        "generated_url"   => url($website->token),
                        "full_url"        => $website->website_full_url
                    ];
                }
            }
        return $websites;
    }
}
