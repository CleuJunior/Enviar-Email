<?php

require "./bibliotecas/PHPMailer/Exception.php";
require "./bibliotecas/PHPMailer/OAuth.php";
require "./bibliotecas/PHPMailer/PHPMailer.php";
require "./bibliotecas/PHPMailer/POP3.php";
require "./bibliotecas/PHPMailer/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mensagem
{
    private $para = null;
    private $assunto = null;
    private $mensagem = null;
    public $status = array('codigo_stauts' => null, 'descricao_status' => '');

    public function getPara()
    {
        return $this->para;
    }

    public function setPara($para)
    {
        $this->para = $para;
    }


    public function getAssunto()
    {
        return $this->assunto;
    }


    public function setAssunto($assunto)
    {
        $this->assunto = $assunto;
    }

    public function getMensagem()
    {
        return $this->mensagem;
    }

    public function setMensagem($mensagem)
    {
        $this->mensagem = $mensagem;
    }

    public function mensagemValida()
    {
        if (empty($this->para) || empty($this->assunto) || empty($this->mensagem)) {
            return false;
        }
        return true;
    }

}

$mensagem = new Mensagem();

$mensagem->setPara($_POST['para']);
$mensagem->setAssunto($_POST['assunto']);
$mensagem->setMensagem($_POST['mensagem']);


if (!$mensagem->mensagemValida()) {
    echo "Mensagem não é valida";
    header('Location: index.php');
}

$mail = new PHPMailer(true);
try {
    //Server settings
    $mail->SMTPDebug = false;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'webcompleto2@gmail.com';                 // SMTP username
    $mail->Password = '!@#$4321';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('webcompleto2@gmail.com', 'Web Completo Remetente');
    $mail->addAddress($mensagem->getPara());     // Add a recipient
//    $mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
//    $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $mensagem->getAssunto();
    $mail->Body = $mensagem->getMensagem();
    $mail->AltBody = 'É necessario usar um client que suporte HTML para ter acesso total ao conteúdo dessa mensagem.';

    $mail->send();

    $mensagem->status['codigo_stauts'] = 1;
    $mensagem->status['descricao_status'] = 'Email enviado com sucesso';

} catch (Exception $e) {

    $mensagem->status['codigo_stauts'] = 2;
    $mensagem->status['descricao_status'] = 'Não foi possível enviar este email. Erro: ' . $mail->ErrorInfo;

}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>App Mail Send</title>
</head>
<body>

<div class="container">
    <div class="py-3 text-center">
        <img class="d-block mx-auto mb-2" src="logo.png" alt="" width="72" height="72">
        <h2>Send Mail</h2>
        <p class="lead">Seu app de envio de e-mails particular!</p>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?php if ($mensagem->status['codigo_stauts'] == 1): ?>
                <div class="container">
                    <h1 class="display-4 text-success">Sucesso</h1>
                    <p><?= $mensagem->status['descricao_status']; ?></p>
                    <a href="index.php" class="btn btn-success btn-lg mt-5 text-white">Voltar</a>
                </div>

            <?php endif; ?>

            <?php if ($mensagem->status['codigo_stauts'] == 2): ?>

                <div class="container">
                    <h1 class="display-4 text-danger">Ops!</h1>
                    <p><?= $mensagem->status['descricao_status']; ?></p>
                    <a href="index.php" class="btn btn-success btn-lg mt-5 text-white">Voltar</a>
                </div>


            <?php endif; ?>

        </div>
    </div>

</div>

</body>
</html>
