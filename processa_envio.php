<?php


class Mensagem{
    private $para = null;
    private $assunto = null;
    private $mensagem = null;

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
        if(empty($this->para) || empty($this->assunto) || empty($this->mensagem)){
            return false;
        }
        return true;
    }

}

$mensagem = new Mensagem();

$mensagem->setPara($_POST['para']);
$mensagem->setAssunto($_POST['assunto']);
$mensagem->setMensagem($_POST['mensagem']);

//print_r($mensagem);

if ($mensagem->mensagemValida()){
    echo "Mensagem valida";

}else{
    echo "Mensagem não valida";
}