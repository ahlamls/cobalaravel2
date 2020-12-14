<?php

namespace App\Http\Controllers;

use DB;
use Image;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function checkLogin($request)
    {
        $data = $request->session()->all();

        if (isset($data['uid'])) {
            $uid = $data['uid'];
            $username = $data['username'];
        } else {
            $uid = 0;
            $username = "";
        }
        return [$uid, $username];
    }

    public function login(Request $request)
    {
        $cl = $this->checkLogin($request);
        $uid = $cl[0];
        $uname = $cl[1];
        if ($uid != 0) {
            return redirect("/");
            die();
        }
        return view('login', ['username' => $uname]);
    }

    public function handleLogin(Request $request)
    {
        $cl = $this->checkLogin($request);
        $uid = $cl[0];
        $uname = $cl[1];
        if ($uid != 0) {
            return redirect("/");
            die();
        }
        $email = $request->input('email');
        $password = hash('sha512', $request->input('password'));
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
            $request->session()->put('username', $username);
            return redirect('/');
        } else {
            return redirect('/login/?error=1');
        }
    }

    public function register(Request $request)
    {
        $cl = $this->checkLogin($request);
        $uid = $cl[0];
        $uname = $cl[1];
        if ($uid != 0) {
            return redirect("/");
            die();
        }
        return view('register', ['username' => $uname]);
    }

    public function handleregister(Request $request)
    {
        $cl = $this->checkLogin($request);
        $uid = $cl[0];
        $uname = $cl[1];
        if ($uid != 0) {
            return redirect("/");
            die();
        }

        $this->validate($request, [
            'email' => 'required',
            'username' => 'required',
            'password' => 'required',
            'passwordc' => 'required',
        ]);

        $email = $request->input('email');
        $username = $request->input('username');
        $password = $request->input('password');
        $passwordc = $request->input('passwordc');

        if ($password != $passwordc) {
            return redirect("/register/?error=3");
            die();
        }
        //check email
        $emails = DB::select("select id from user WHERE `email` = '$email'  LIMIT 0,1");
        foreach ($emails as $emai) {
            return redirect("/register/?error=1");
            die();
        }
        //check username
        $usernames = DB::select("select id from user WHERE `username` = '$username'  LIMIT 0,1");
        foreach ($usernames as $userna) {
            return redirect("/register/?error=2");
            die();
        }
        $hashed_pass = hash('sha512', $request->input('password'));
        try {
            DB::insert("INSERT INTO `user` (`id`, `time`, `username`, `password`, `email`, `bio`) VALUES (NULL, NOW(), '$username', '$hashed_pass', '$email', 'this user still use default bio');");
        } catch (Exception $e) {
            return redirect('/login/?error=3');
            die();
        }
        return redirect('/login/?error=2');
        die();
    }

    public function upload(Request $request)
    {
        $cl = $this->checkLogin($request);
        $uid = $cl[0];
        $uname = $cl[1];
        if ($uid == 0) {
            return redirect("/login");
            die();
        }
        return view('upload', ['username' => $uname]);
    }

    public function handleupload(Request $request)
    {
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
            if ($extension == "php" or $extension == "html" or $extension == "asp" or $extension == "aspx" or $extension == "php2" or $extension == "php3" or $extension == "php4" or $extension == "php5" or $extension == "htm") {
                die("<h1>Deface Attempt Detected!</h1>");
            }
            if ($extension == "png" or $extension == "jpg" or $extension == "jpeg" or $extension = "gif") {
                $rand = (String) rand(69, 177013);
                $filename = hash('sha512', $file->getClientOriginalName() . $rand) . "." . $extension . ".jpg";
               
                $wm = Image::make(public_path("wm.png"));  
                $wm->text('http://localhost:82/p/69
localhost:82/u/test', 10, 10, function($font) {  
                    $font->file(public_path('font.ttf'));  
                    $font->size(30);  
                    $font->color('#e1e1e1');  
                    $font->align('left');  
                    $font->valign('top');  
                });  
               
                $img = Image::make($file->getRealPath());
                $img->resize(640, 1536, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->resizeCanvas(0,70, 'top', true);
                $img->insert($wm, 'bottom', 0, 0);
                $imgx = Image::make($img->encode('jpg', 20));
                $imgx->save(public_path("image/" . $filename));
                $image_url = "/image/" . $filename;
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

    public function vote(Request $request)
    {
        $cl = $this->checkLogin($request);
        $uid = $cl[0];
        $uname = $cl[1];
        if ($uid == 0) {
            return response()->json([
                'success' => false,
                'message' => 'not logged in',
            ]);
            die();
        }

        $this->validate($request, [
            'type' => 'required',
            'id' => 'required',
        ]);

        $post_id = $request->input('id');
        $type = $request->input('type');
        if (!($type == 1 or $type == 0)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Type',
            ]);
            die();
        }

        //button state
        $uvb = false;
        $dvb = false;

        $votecheck = DB::select("SELECT * FROM `vote` WHERE `post_id` = '$post_id' AND `user_id` = '$uid' LIMIT 0,1");
        $vt = 2;
        $v_id = 0;
        foreach ($votecheck as $vc) {
            $vt = $vc->type;
            $v_id = $vc->id;
        }
        try {
            if ($type == 0) { //downvote
                if ($vt == 0) {
                    DB::delete("DELETE FROM `vote` WHERE `id` = $v_id");
                    DB::update("UPDATE `image` SET `vote` = `vote` + 1 WHERE `image`.`id` = $post_id;");
                } else if ($vt == 1) {
                    DB::update("UPDATE `vote` SET `type` = '0' WHERE `id` = $v_id;");
                    DB::update("UPDATE `image` SET `vote` = `vote` - 2 WHERE `image`.`id` = $post_id;");
                    $dvb = true;
                } else {
                    DB::insert("INSERT INTO `vote` (`id`, `post_id`, `user_id`, `type`) VALUES (NULL, '$post_id', '$uid', '0');");
                    DB::update("UPDATE `image` SET `vote` = `vote` - 1 WHERE `image`.`id` = $post_id;");
                    $dvb = true;
                }
            } else { //upvote
                if ($vt == 0) {
                    DB::update("UPDATE `vote` SET `type` = '1' WHERE `id` = $v_id;");
                    DB::update("UPDATE `image` SET `vote` = `vote` + 2 WHERE `image`.`id` = $post_id;");
                    $uvb = true;
                } else if ($vt == 1) {
                    DB::delete("DELETE FROM `vote` WHERE `id` = $v_id");
                    DB::update("UPDATE `image` SET `vote` = `vote` - 1  WHERE `image`.`id` = $post_id;");

                } else {
                    DB::insert("INSERT INTO `vote` (`id`, `post_id`, `user_id`, `type`) VALUES (NULL, '$post_id', '$uid', '1');");
                    DB::update("UPDATE `image` SET `vote` = `vote` + 1 WHERE `image`.`id` = $post_id;");
                    $uvb = true;
                }
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Database Error Occured',
            ]);
            die();
        }

        $votecountcheck = DB::select("SELECT vote FROM `image` WHERE `id` = '$post_id'  LIMIT 0,1");
        $votecount = 0;
        foreach ($votecountcheck as $vcc) {
            $votecount = $vcc->vote;
        }

        return response()->json([
            'success' => true,
            'vc' => $votecount,
            'dvb' => $dvb,
            'uvb' => $uvb,
        ]);
        die();

    }

    public function getcomment(Request $request) {
        $cl = $this->checkLogin($request);
        $uid = $cl[0];
        $uname = $cl[1];
        $this->validate($request, [
            'id' => 'required',
        ]);
        $post_id = $request->input('id');
        $output = "";

        $comments = DB::select("SELECT * FROM `comment` WHERE `post_id` = $post_id");
        foreach ($comments as $comment) {
            $usernames = DB::select('select * from user WHERE `id` = ' . $comment->user_id);
            $username = "Unknown";
            foreach ($usernames as $usernam) {
                $username = $usernam->username;
            }

            $output .= "  <div class='comment marg'>
            <p>
                <a href='/u/$username' class='link'><b>$username</b></a> <span class='text-muteds'>$comment->time</span><br>
                " . e($comment->comment) . "
            </p>
        </div>";
        }
        if ($output == "") {
            $output = "<p class='text-muteds center'>No Comment Found</p>";
        }
        die($output);
    }

    public function docomment(Request $request) {
        $cl = $this->checkLogin($request);
        $uid = $cl[0];
        $uname = $cl[1];
        if ($uid == 0) {
            return response()->json([
                'success' => false,
                'message' => 'not logged in',
            ]);
            die();
        }

        $this->validate($request, [
            'id' => 'required',
            'comment' => 'required',
        ]);
        $post_id = $request->input('id');
        $comment = e($request->input('comment'));
        
        $users = DB::select("SELECT UNIX_TIMESTAMP(time) as timestamp FROM `comment` WHERE `user_id` = 1 ORDER BY `id` DESC LIMIT 0,1");
        foreach ($users as $user) {
            if (time() - $user->timestamp < 60 ) {
                return response()->json([
                    'success' => false,
                    'message' => 'You need to wait at least 1 minute between each comment',
                ]);
                die();
            }
        }
        try {
            DB::insert("INSERT INTO `comment` (`id`, `user_id`, `post_id`, `comment`, `vote`) VALUES (NULL, '$uid', '$post_id', '$comment', '0')");
            DB::update("UPDATE `image` SET `commentcount` = `commentcount` + 1 WHERE `image`.`id` = $post_id;");
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Database Error Occured',
            ]);
            die();
        }

        return response()->json([
            'success' => true,
            'message' => 'success',
        ]);
        die();

    }

    public function index(Request $request)
    {
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

            $uvb = "btn-secondary";
            $dvb = "btn-secondary";
            if ($uid !== 0) {
                $votecheck = DB::select("SELECT * FROM `vote` WHERE `post_id` = '$post->id' AND `user_id` = '$uid' LIMIT 0,1");
                $vt = 2;
                $v_id = 0;
                foreach ($votecheck as $vc) {
                    $vt = $vc->type;
                    $v_id = $vc->id;
                }

                if ($vt == 0) {
                    $dvb = "btn-danger";
                } else if ($vt == 1) {
                    $uvb = "btn-success";
                }
            }

            $content .= "
            <div class='card'>
             <div class='card-header'><i class='fas fa-user'></i>  <a class='link' href='/u/$username'><b>$username</b></a> |  <span class='text-muteds'><i class='fas fa-clock'></i>  $post->time</span></div>

             <div class='row'>
                 <div class='col-md-9 col-12 pad5'>
                     <a href='/p/$post->id'><img src='$post->image_url' class='card-img-top w-100' alt='" . e($post->caption) . "'></a>
                </div>
            <div class='col-md-3 col-12'>
                <div class='card-body'>
                    <p class='card-text'><b>" . e($post->caption) . "</b></p>
                    <p class='card-text text-muteds'><b id='vc$post->id'>$post->vote</b> Votes</p>
                    <p class='card-text'>
                        <button class='btn btn-sm $uvb marg' id='uvb$post->id' onclick='upvote($post->id)'><i class='fas fa-arrow-up'></i> Up</button>
                        <button class='btn btn-sm $dvb marg' id='dvb$post->id' onclick='downvote($post->id)'><i class='fas fa-arrow-down'></i> Down</button>
                        <button class='btn btn-sm btn-primary marg' id='cb$post->id' onclick='comment($post->id)'>Comment($post->commentcount)</button>
                        <button class='btn btn-sm btn-info marg' id='cpbtn'  data-clipboard-text='" . $request->getSchemeAndHttpHost() ."/p/$post->id'><i class='far fa-copy'></i> Link</button>
                  
                        </p>
                </div>
            </div>
            </div>
            </div>

            <br>
            ";
        }

        if ($content == "") {
            $content = "<p class='text-muteds center'>no more posts left</p>";
        }

        return view('home', ['content' => $content, 'username' => $uname]);

    }

    public function post(Request $request , $id)
    {
        $cl = $this->checkLogin($request);
        $uid = $cl[0];
        $uname = $cl[1];
        $images = DB::select('select * from image WHERE `hidden` = 0 AND `id` = ' . $id .' ORDER BY `id` DESC');
        $title = "No Post Found";
        $content = "";
        foreach ($images as $post) {
            $usernames = DB::select('select * from user WHERE `id` = ' . $post->user_id);
            $username = "Unknown";
            foreach ($usernames as $usernam) {
                $username = $usernam->username;
            }

            $uvb = "btn-secondary";
            $dvb = "btn-secondary";
            if ($uid !== 0) {
                $votecheck = DB::select("SELECT * FROM `vote` WHERE `post_id` = '$post->id' AND `user_id` = '$uid' LIMIT 0,1");
                $vt = 2;
                $v_id = 0;
                foreach ($votecheck as $vc) {
                    $vt = $vc->type;
                    $v_id = $vc->id;
                }

                if ($vt == 0) {
                    $dvb = "btn-danger";
                } else if ($vt == 1) {
                    $uvb = "btn-success";
                }
            }
         $title = $post->caption;
            $content .= "
            <div class='card'>
             <div class='card-header'><i class='fas fa-user'></i>  <a class='link' href='/u/$username'><b>$username</b></a> |  <span class='text-muteds'><i class='fas fa-clock'></i>  $post->time</span></div>

             <div class='row'>
                 <div class='col-md-9 col-12 pad5'>
                     <img src='$post->image_url' class='card-img-top w-100' alt='" . e($post->caption) . "'>
                </div>
            <div class='col-md-3 col-12'>
                <div class='card-body'>
                    <p class='card-text'><b>" . e($post->caption) . "</b></p>
                    <p class='card-text text-muteds'><b id='vc$post->id'>$post->vote</b> Votes</p>
                    <p class='card-text'>
                        <button class='btn btn-sm $uvb marg' id='uvb$post->id' onclick='upvote($post->id)'><i class='fas fa-arrow-up'></i> Up</button>
                        <button class='btn btn-sm $dvb marg' id='dvb$post->id' onclick='downvote($post->id)'><i class='fas fa-arrow-down'></i> Down</button>
                        <button class='btn btn-sm btn-primary marg' id='cb$post->id' onclick='comment($post->id)'>Comment ($post->commentcount)</button>
                        <button class='btn btn-sm btn-info marg' id='cpbtn'  data-clipboard-text='" . $request->getSchemeAndHttpHost() ."/p/$post->id'><i class='far fa-copy'></i> Link</button>
                  
                        </p>
                </div>
            </div>
            </div>
            </div>

            <br>
            ";
        }

        if ($content == "") {
            $content = "<p class='text-muteds center'>no more posts left</p>";
        }

        

        return view('home', ['content' => $content, 'username' => $uname, 'title' => $title]);

    }

    public function profile(Request $request, $username)
    {
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

            $uvb = "btn-secondary";
            $dvb = "btn-secondary";
            if ($uid !== 0) {
                $votecheck = DB::select("SELECT * FROM `vote` WHERE `post_id` = '$post->id' AND `user_id` = '$uid' LIMIT 0,1");
                $vt = 2;
                $v_id = 0;
                foreach ($votecheck as $vc) {
                    $vt = $vc->type;
                    $v_id = $vc->id;
                }

                if ($vt == 0) {
                    $dvb = "btn-danger";
                } else if ($vt == 1) {
                    $uvb = "btn-success";
                }
            }

            $content .= "
            <div class='card'>
             <div class='card-header'><i class='fas fa-user'></i>  <b>$username</b> |  <span class='text-muteds'><i class='fas fa-clock'></i>  $post->time</span></div>

             <div class='row'>
                 <div class='col-md-9 col-12 pad5'>
                     <img src='$post->image_url' class='card-img-top w-100' alt='" . e($post->caption) . "'>
                </div>
            <div class='col-md-3 col-12'>
                <div class='card-body'>
                    <p class='card-text'><b>" . e($post->caption) . "</b></p>
                    <p class='card-text text-muteds'><b id='vc$post->id'>$post->vote</b> Votes</p>
                    <p class='card-text'>
                        <button class='btn btn-sm $uvb marg' id='uvb$post->id' onclick='upvote($post->id)'><i class='fas fa-arrow-up'></i> Up</button>
                        <button class='btn btn-sm $dvb marg' id='dvb$post->id' onclick='downvote($post->id)'><i class='fas fa-arrow-down'></i> Down</button>
                        <button class='btn btn-sm btn-primary marg' id='cb$post->id' onclick='comment($post->id)'>Comment ($post->commentcount)</button>
                        <button class='btn btn-sm btn-info marg' id='cpbtn'  data-clipboard-text='" . $request->getSchemeAndHttpHost() ."/p/$post->id'><i class='far fa-copy'></i> Link</button>
                  
                        </p>
                </div>
            </div>
            </div>
            </div>

            <br>
            ";
        }

        if ($content == "") {
            $content = "<p class='text-muteds center'>This user never upload any posts</p>";
        }

        return view('profile', ['content' => $content, 'username' => $uname, 'profiles' => $profiles]);

    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/login');
    }

    public function setting(Request $request)
    {
        $cl = $this->checkLogin($request);
        $uid = $cl[0];
        $uname = $cl[1];
        if ($uid == 0) {
            return redirect("/login");
            die();
        }
        return view('setting', ['username' => $uname]);
    }

}
