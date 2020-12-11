<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class HomeController extends Controller
{
    public function checkLogin($request) {
        $data = $request->session()->all();
        
        if (isset($data['uid'])) {
            $uid =  $data['uid'];
            $username = $data['username'];   
        } else {
            $uid = 0;
            $username = "";
        }
        return [$uid,$username];
    }

    public function login(Request $request) {
        $cl = $this->checkLogin($request);
        $uid = $cl[0];
        $uname = $cl[1];
        if ($uid != 0) {
            return redirect("/");
            die();
        }
        return view('login',['username' => $uname]);
    }

    public function handleLogin(Request $request) {
        $cl = $this->checkLogin($request);
        $uid = $cl[0];
        $uname = $cl[1];
        if ($uid != 0) {
            return redirect("/");
            die();
        }
        $email = $request->input('email');
        $password = hash('sha512',$request->input('password'));
        $users = DB::select("select * from user WHERE `email` = '$email' AND `password` = '$password' LIMIT 0,1");
        $exist = false;
        $uid = 0; 
        $username = "";
        foreach ($users as $user) {
            $exist = true;
            $uid = $user->id;
            $username = $user->username;
        }

        if ($exist) {
            $request->session()->put('uid', $uid);
            $request->session()->put('username' , $username);
            return redirect('/');
        } else {
            return redirect('/login/?error=1');
        }
    }

    public function register(Request $request) {
        $cl = $this->checkLogin($request);
        $uid = $cl[0];
        $uname = $cl[1];
        if ($uid != 0) {
            return redirect("/");
            die();
        }
        return view('register',['username' => $uname]);
    }

    public function upload(Request $request) {
        $cl = $this->checkLogin($request);
        $uid = $cl[0];
        $uname = $cl[1];
        if ($uid == 0) {
            return redirect("/login");
            die();
        }
        return view('upload',['username' => $uname]);
    }

    public function handleupload(Request $request) {
        $cl = $this->checkLogin($request);
        $uid = $cl[0];
        $uname = $cl[1];
        if ($uid == 0) {
            return redirect("/login");
            die();
        }

        $this->validate($request, [
            'caption' => 'required',
            'file' => 'required',
        ]);

        $file = $request->file('file');
        $caption = $request->input('caption');
        if ($file !== null) {
           $extension = $file->getClientOriginalExtension();
           if ($extension == "php" OR $extension == "html" OR $extension == "asp" OR $extension == "aspx" OR $extension == "php2" OR $extension == "php3" OR $extension == "php4" OR $extension == "php5" OR $extension == "htm") {
               die("<h1>Deface Attempt Detected!</h1>");
           }
           if ($extension == "png" OR $extension == "jpg" OR $extension =="jpeg" OR $extension = "gif") {
            $rand = (String) rand(69,177013);
            $filename = hash('sha512', $file->getClientOriginalName() . $rand) . "." . $extension;
            $file->move("image",$filename);
            $image_url = "/image/" . $filename ;
           } else {
              return redirect('/upload/?error=1');
              die();
           }
        } else {
            return redirect('/upload/?error=2');
            die();
        }
        DB::insert("INSERT INTO `image` (`id`, `user_id`, `time`, `caption`, `vote`, `commentcount`, `image_url`, `hidden`) VALUES (NULL, '$uid', current_timestamp(), '$caption', '0', '0', '$image_url', '0');");
        return redirect('/');
    }

    public function index(Request $request) {
        $cl = $this->checkLogin($request);
        $uid = $cl[0];
        $uname = $cl[1];
        $images = DB::select('select * from image WHERE `hidden` = 0 ORDER BY `id` DESC');
        $content = "";
        foreach ($images as $post) {
            $usernames = DB::select('select * from user WHERE `id` = ' . $post->user_id);
            $username = "Unknown";
            foreach ($usernames as $usernam) {
                $username = $usernam->username;
            }

            $content .= "
            <div class='card'>
             <div class='card-header'><i class='fas fa-user'></i>  <b>$username</b> |  <span class='text-muted'><i class='fas fa-clock'></i>  $post->time</span></div>

             <div class='row'>
                 <div class='col-md-9 col-12 pad5'>
                     <img src='$post->image_url' class='card-img-top w-100' alt='" . e($post->caption) . "'>
                </div>
            <div class='col-md-3 col-12'>
                <div class='card-body'>
                    <p class='card-text'><b>" . e($post->caption) . "</b></p>
                    <p class='card-text text-muted'><b>$post->vote</b> Votes</p>
                    <p class='card-text'>
                        <button class='btn btn-sm btn-secondary marg' onclick='upvote($post->id)'><i class='fas fa-arrow-up'></i> Up</button>
                        <button class='btn btn-sm btn-secondary marg' onclick='downvote($post->id)'><i class='fas fa-arrow-down'></i> Down</button>
                        <button class='btn btn-sm btn-primary marg' onclick='comment($post->id)'>Comment ($post->commentcount)</button>
                    </p>
                </div>
            </div>
            </div>
            </div>
            
            <br>
            ";
        }
        
        return view('home',['content' => $content ,'username' => $uname]);   

    }

    public function profile(Request $request,$username) {
        $cl = $this->checkLogin($request);
        $uid = $cl[0];
        $uname = $cl[1];

        $profiles = DB::select('select * from user WHERE `username` = "' . $username . '" LIMIT 0,1');
        $username = "Unknown";
        $exist = false;
        $id = 0;
        foreach ($profiles as $usernam) {
            $username = $usernam->username;
            $pid = $usernam->id;
            $exist = true;
        }
        if (!$exist) {
            return redirect("/");
            die();
        }

        $images = DB::select("select * from image WHERE `hidden` = 0 AND `user_id` = $pid  ORDER BY `id` DESC");
        $content = "";
        foreach ($images as $post) {

            $content .= "
            <div class='card'>
             <div class='card-header'><i class='fas fa-user'></i>  <b>$username</b> |  <span class='text-muted'><i class='fas fa-clock'></i>  $post->time</span></div>

             <div class='row'>
                 <div class='col-md-9 col-12 pad5'>
                     <img src='$post->image_url' class='card-img-top w-100' alt='" . e($post->caption) . "'>
                </div>
            <div class='col-md-3 col-12'>
                <div class='card-body'>
                    <p class='card-text'><b>" . e($post->caption) . "</b></p>
                    <p class='card-text text-muted'><b>$post->vote</b> Votes</p>
                    <p class='card-text'>
                        <button class='btn btn-sm btn-secondary marg' onclick='upvote($post->id)'><i class='fas fa-arrow-up'></i> Up</button>
                        <button class='btn btn-sm btn-secondary marg' onclick='downvote($post->id)'><i class='fas fa-arrow-down'></i> Down</button>
                        <button class='btn btn-sm btn-primary marg' onclick='comment($post->id)'>Comment ($post->commentcount)</button>
                    </p>
                </div>
            </div>
            </div>
            </div>
            
            <br>
            ";
        }
        
        return view('profile',['content' => $content ,'username' => $uname , 'profiles' => $profiles]);   

    }

    public function logout(Request $request) {
        $request->session()->flush();
        return redirect('/login');
    }

}
