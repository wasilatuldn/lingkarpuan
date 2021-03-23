<?php

use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;
use Phalcon\Mvc\Dispatcher;
use App\Validation\UserValidation;
use App\Events\UserProtectController;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class UserController extends Controller
{
    
    public function registerAction()
    {
		
    }


    public function postregisterAction()
    {
        $random = new \Phalcon\Security\Random();
        $user = new User();

        $id_user = $random->uuid();
        $email = $this->request->getPost('email');
        $nama = $this->request->getPost('nama');
        $password = $this->request->getPost('password');
        $kode_verifikasi = $random->uuid();

        $user->id_user = $id_user;
        $user->id_role = 1;
        $user->email = $email;
        $user->nama = $nama;
        $user->password = $this->security->hash($password);
        $user->status_verifikasi = 0;
        $user->kode_verifikasi = $kode_verifikasi;
        
        //kirim email verifikasi
        $this->sendlink($kode_verifikasi, $email, $nama);
        // var_dump($user);
        $user->save();
        $this->response->redirect('user/login');
    }

    public function sendlink($kode, $email, $nama)
    {
        $message = file_get_contents(APP_PATH . '/templates/emailverifikasi.html');
        $link = "http://localhost/lingkarpuan/user/verifikasi?email=" . $email . "&verifikasi=" . $kode;
        // echo $link; die();
        $message = str_replace('%link%', $link, $message);

        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = '7a1fd2f7381fc9';
            $mail->Password = 'fc941de8104ce3';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 2525;

            //Recipients
            $mail->setFrom('email@lingkarpuan.com', 'Lingkar Puan');
            $mail->addAddress($email, $nama);

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Verifikasi Akun - Lingkar Puan';
            $mail->MsgHTML($message);
            $mail->CharSet = "utf-8";
            // $mail->AltBody = 'Berikut adalah kode untuk verifikasi email = ' . $kode;

            $mail->send();
            echo 'Message has been sent';
           // print_r('Message has been sent');
            //die();
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
            //print_r('Message could not be sent. Mailer Error: ', $mail->ErrorInfo);
            //die();
        }
    }

    public function loginAction()
    {

    }

    public function storeloginAction()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = User::findFirst("email='$email'");

        if ($user) {
            if ($this->security->checkHash($password, $user->password)) {
                if($user->status_verifikasi == 1)
                {
                    $this->session->set(
                        'user',
                        [
                            'id' => $user->id_user,
                            'nama' => $user->nama,
                            'role' => $user->id_role,
                        ]
                    );
                    (new Response())->redirect()->send();
                }
                else
                {
                    $this->response->redirect('user/login');
                }
                
            }
            else{
                $this->response->redirect('user/login');
            }
        }
        else{
            $this->response->redirect('user/login');
        }

    }

    public function logoutAction()
    {
        $this->session->destroy();
        $this->response->redirect();
    }

    public function verifikasiAction()
    {
        $email = $this->request->get('email');
        $kode_verifikasi = $this->request->get('verifikasi');
        $user = User::findFirst(
            [
                'columns' => '*',
                'conditions' => 'email = ?1 AND kode_verifikasi = ?2',
                'bind' => [
                    1 => $email,
                    2 => $kode_verifikasi,
                ]
            ]
        );

        if ($user) {
            $user->status_verifikasi = 1;
            $user->save();
            $this->response->redirect('');
        }
        else
        {
            $this->response->redirect('user/gagalverifikasi');
        }
    }

    public function gagalverifikasiAction()
    {

    }

}