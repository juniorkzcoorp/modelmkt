<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * DESENVOLVIDO POR BRUNO ALMEIDA
 *
 * DEZEMBRO DE 2013
 */

class Site extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('gercont_model');
    }

    /**
     *
     * index
     * 
     * Página inicial do site
     * 
     *
     * @access	public
     * @param	null
     * @return	null
     */
    public function index() {

        $data = array();

        $data['configuracoes'] = $this->gercont_model->configuracoes();
        $data['js'] = "<script src='./public/codemin/js/jquery.meiomask.js'></script>
        <script> $(document).ready(function(){ $('input[type=\"text\"]').setMask(); });</script>
        <script src='./public/js/jquery.validate.min.js'></script>";        

        $this->load->view('includes/header', $data);
        $this->load->view('home');
        $this->load->view('includes/footer');
    }

    /**
     *
     * conteudo
     * 
     * Exibi uma página de conteúdo
     * 
     *
     * @access	public
     * @param	null
     * @return	null
     */
    public function conteudo() {

        $data = array();

        $conteudo = $this->gercont_model->conteudo($this->uri->segment(1));
        if (!$conteudo) {
            $this->erro_404();
        } else {

            $data['configuracoes'] = $this->gercont_model->configuracoes();
            $data['conteudo'] = $conteudo;
            $data['titulo'] = $data['conteudo']->titulo;
            $data['pgkeywords'] = $data['conteudo']->keywords;
            $data['pgdescription'] = $data['conteudo']->description;
            $data['js'] = "<script src='./public/codemin/js/jquery.meiomask.js'></script>
        <script> $(document).ready(function(){ $('input[type=\"text\"]').setMask(); });</script>
        <script src='./public/js/jquery.validate.min.js'></script>";

            $this->load->view('includes/header', $data);
            $this->load->view('conteudos/detalhes');
            $this->load->view('includes/footer');
        }
    }

    /**
     *
     * conteudos
     * 
     * Exibi uma página com listagem de conteúdos selecionados no menu
     * 
     *
     * @access	public
     * @param	null
     * @return	null
     */
    public function conteudos() {

        $data = array();

        $conteudos = $this->gercont_model->conteudos($this->uri->segment(2));
        if (!$conteudos) {
            $this->erro_404();
        } else {

            $data['configuracoes'] = $this->gercont_model->configuracoes();
            $data['conteudos'] = $conteudos;
            $data['titulo'] = "Conteúdos";
            $data['js'] = "<script src='./public/codemin/js/jquery.meiomask.js'></script>
        <script> $(document).ready(function(){ $('input[type=\"text\"]').setMask(); });</script>
        <script src='./public/js/jquery.validate.min.js'></script>";

            $this->load->view('includes/header', $data);
            $this->load->view('conteudos/listar');
            $this->load->view('includes/footer');
        }
    }

    /**
     *
     * contato
     * 
     * Exibi o formulário de contato e mapa do google maps
     * 
     *
     * @access	public
     * @param	null
     * @return	null
     */
    public function contato() {

        $data = array();

        $data['configuracoes'] = $this->gercont_model->configuracoes();
        $data['contato'] = $this->gercont_model->contato();
        $data['titulo'] = $data['contato']->titulo;

        $coordenadas = $data['contato']->localizacao;
        $data['js'] = "<script src='./public/codemin/js/jquery.meiomask.js'></script>
		<script> $(document).ready(function(){ $('input[type=\"text\"]').setMask(); });</script>
		<script src='./public/js/jquery.validate.min.js'></script>";

        $this->load->view('includes/header', $data);
        $this->load->view('contato');
        $this->load->view('includes/footer');
    }

    public function trabalhe_conosco() {

        $data = array();

        $data['configuracoes'] = $this->gercont_model->configuracoes();
        $data['contato'] = $this->gercont_model->contato();
        $data['titulo'] = 'Trabalhe Conosco';

        $coordenadas = $data['contato']->localizacao;
        $data['js'] = "<script src='./public/codemin/js/jquery.meiomask.js'></script>
        <script> $(document).ready(function(){ $('input[type=\"text\"]').setMask(); });</script>
        <script src='./public/js/jquery.validate.min.js'></script>";

        $this->load->view('includes/header', $data);
        $this->load->view('trabalhe_conosco');
        $this->load->view('includes/footer');

    }

    
    public function servicos() {

        $data = array();

        $data['configuracoes'] = $this->gercont_model->configuracoes();
        $data['contato'] = $this->gercont_model->contato();
        $data['titulo'] = 'Serviços';

        $coordenadas = $data['contato']->localizacao;
        $data['js'] = "<script src='./public/codemin/js/jquery.meiomask.js'></script>
        <script> $(document).ready(function(){ $('input[type=\"text\"]').setMask(); });</script>
        <script src='./public/js/jquery.validate.min.js'></script>";

        $this->load->view('includes/header', $data);
        $this->load->view('servicos');
        $this->load->view('includes/footer');

    }

    public function resultado_da_busca(){
        
        $data = array();
        $data['configuracoes'] = $this->gercont_model->configuracoes();
        $data['titulo'] = "Resultado da busca";

        $data['produto'] = $this->db->from('catalogo_produtos')->where("nome LIKE '%".$this->input->post('palavraChave')."%' OR descricao LIKE '%".$this->input->post('palavraChave')."%' AND ativo = 1 ")->get()->result();

        if(!$this->input->post('palavraChave') || is_null($this->input->post('palavraChave')) ){
            $data['produto'] = null;
        }


        $data['noticias'] = $this->db->from('noticias')->where("titulo LIKE '%".$this->input->post('palavraChave')."%' OR chamada LIKE '%".$this->input->post('palavraChave')."%' OR texto LIKE '%".$this->input->post('palavraChave')."%' AND ativo = 1 ")->get()->result();

        if(!$this->input->post('palavraChave') || is_null($this->input->post('palavraChave')) ){
            $data['noticias'] = null;
        }

        //echo $this->db->last_query();

        $data['conteudo'] = $this->db->from('conteudo')->where("titulo LIKE '%".$this->input->post('palavraChave')."%' OR texto LIKE '%".$this->input->post('palavraChave')."%' AND ativo = 1 ")->get()->result();

        if(!$this->input->post('palavraChave') || is_null($this->input->post('palavraChave')) ){
            $data['conteudo'] = null;
        }

       // echo $this->db->last_query();

        $data['palavraChave'] = $this->input->post('palavraChave');


        $this->load->view('includes/header',$data);
        $this->load->view('resultado-da-busca');
        $this->load->view('includes/footer');
    }               

    /**
     *
     * enviar_contato
     * 
     * Faz o disparo do email com o contato e guarda no banco de dados
     * 
     *
     * @access	public
     * @param	null
     * @return	null
     */
    public function enviar_contato() {

        $emails = $this->gercont_model->contato()->emails;
        $destinatarios = array();
        foreach (explode(',', $emails) as $destinatario) {
            $destinatarios[] = trim($destinatario);
        }

        $nome = $this->input->post('nome');
        $email = $this->input->post('email');
        $telefone = $this->input->post('telefone');
        $mensagem = $this->input->post('mensagem');
        $interessado = $this->input->post('interessado');
        $captcha = $this->input->post('captcha');
        $nomeProduto = $this->input->post('nomeProduto');

        if( $captcha !== $this->session->userdata('captcha') ){
            $retorno['sucesso'] = false;
            $retorno['mensagem'] = 'Captcha inválido!';
            echo json_encode($retorno);
            exit();
        }
        
        $insert = array(
            'nome' => $nome,
            'email' => $email,
            'telefone' => $telefone,
            'mensagem' => $mensagem,
            'interessado' => $interessado,
            'nomeProduto' => $nomeProduto,
            'data_hora' => date('Y-m-d H:i:s')
        );

        $config['upload_path'] = './uploads/curriculos';
        $config['allowed_types'] = '*';
        $config['max_size'] = '999999';
        $config['max_width']  = '1024';
        $config['max_height']  = '768';
        $config['file_name'] = date('YmdHis').rand(11,99);

        if(!is_dir($config['upload_path'])){
            
             //echo "Entrou no if para talvez criação de pasta";
            
            @mkdir($config['upload_path']);
             
             //echo "Criou a pasta";
        }

        $this->load->library('upload', $config);

        
        //$this->upload->display_errors();

        
        if($this->upload->do_upload('curriculo')) {

            //echo "Entrou aqui! dentro do IF";

            $retornoCurriculo = $this->upload->data();

            $insert['anexo'] = $retornoCurriculo['orig_name'];

            //echo "Deu load na library <br>";

        }else {
    
           // $retorno['sucesso'] = false;
           // $retorno['mensagem'] = $this->upload->display_errors();;

        $this->upload->display_errors();


        }
        
        $this->db->insert('codemin_contatos', $insert);

        if($this->input->post('trabalheConosco') == 1){
                
                 $assunto = "Cimtel [Trabalhe Conosco]";

        }else {
                 $assunto = "Cimtel [Contato Pelo Site]";
        
        }
        
        $corpo = $this->load->view('contato_email', $insert, true);

        $retorno = array();

        if (enviar_email($destinatarios, $assunto, $corpo, $email)) {
            $retorno['sucesso'] = true;
        } else {
            $retorno['sucesso'] = false;
            $retorno['mensagem'] = "Houve um erro ao enviar sua mensagem, por favor, tente novamente mais tarde.";
        }

        echo json_encode($retorno);
    }

    /**
     *
     * erro_404
     * 
     * Exibi a página não encontrada
     * 
     *
     * @access	private
     * @param	null
     * @return	null
     */
    private function erro_404() {

        $data['configuracoes'] = $this->gercont_model->configuracoes();
        $data['titulo'] = "Página não encontrada";

        $this->load->view('includes/header', $data);
        $this->load->view('erro_404');
        $this->load->view('includes/footer');
    }

    /**
     *
     * sitemap
     * 
     * Monta o sitemap xml do site
     * 
     *
     * @access	public
     * @param	null
     * @return	null
     */
    public function sitemap() {

        $this->load->library('sitemap');
        $this->load->model('sitemap_model');

        $sitemap = new Sitemap();

        $ultima_modificacao = $this->sitemap_model->ultima_modificacao();

        // Home
        $sitemap->add(base_url(), $ultima_modificacao, '1.0', 'weekly');

        // Contato
        if ($this->config->item('gercont-gerenciar-contato'))
            $sitemap->add(base_url('/contato/'), $ultima_modificacao, '0.5', 'monthly');


        // Notícias
        if ($this->config->item('gercont-gerenciar-noticias')) {

            $importancia = '0.5';
            $frequencia = 'weekly';
            $noticias = $this->sitemap_model->registros('noticias', 'url_titulo');
            foreach ($noticias as $noticia) {
                $sitemap->add(base_url('/noticias/' . $noticia->url_titulo), $noticia->data, $importancia, $frequencia);
            }
        } // Notícias
        // Galerias de Fotos
        if ($this->config->item('gercont-gerenciar-fotos')) {

            $importancia = '0.5';
            $frequencia = 'weekly';
            $fotos = $this->sitemap_model->registros('galerias_fotos', 'url_nome');
            foreach ($fotos as $foto) {
                $sitemap->add(base_url('/galerias-fotos/' . $foto->url_nome), $foto->data, $importancia, $frequencia);
            }
        } // Galerias de Fotos
        // Galerias de Vídeos
        if ($this->config->item('gercont-gerenciar-videos')) {

            $importancia = '0.5';
            $frequencia = 'weekly';
            $videos = $this->sitemap_model->registros('videos', 'url_titulo');
            foreach ($videos as $video) {
                $sitemap->add(base_url('/galerias-videos/' . $video->url_titulo), $video->data, $importancia, $frequencia);
            }
        } // Galerias de Vídeos
        // Catálogo de Produtos
        if ($this->config->item('gercont-gerenciar-catalogo')) {

            $importancia = '0.5';
            $frequencia = 'weekly';
            $produtos = $this->sitemap_model->registros('catalogo_produtos', 'url_nome');
            foreach ($produtos as $produto) {
                $sitemap->add(base_url('/catalogo/' . $produto->url_nome), $produto->data, $importancia, $frequencia);
            }
        } // Catálogo de Produtos
        // show your sitemap (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
        $sitemap->render('xml');
    }

    /**
     *
     * robotstxt
     * 
     * Monta o robots txt
     * 
     *
     * @access	public
     * @param	null
     * @return	null
     */
    public function robotstxt() {

        $data = array();

        $data['allow'][] = '*';

        // Codemin
        $data['disallow'][] = '/administrador';
        $data['disallow'][] = '/instalar';
        $data['disallow'][] = '/opcoes';
        $data['disallow'][] = '/uploader';

        // Funções do Carrinho
        $data['disallow'][] = '/catalogo/carrinho/adicionar';
        $data['disallow'][] = '/catalogo/carrinho/remover';
        $data['disallow'][] = '/catalogo/carrinho/limpar';
        $data['disallow'][] = '/catalogo/carrinho/atualizar';
        $data['disallow'][] = '/catalogo/carrinho/finalizado';

        // Enviar newsletter e contato
        $data['disallow'][] = '/*/enviar';

        if (!$this->config->item('gercont-gerenciar-noticias'))
            $data['disallow'][] = '/noticias';

        if (!$this->config->item('gercont-gerenciar-contato'))
            $data['disallow'][] = '/contato';

        if (!$this->config->item('gercont-gerenciar-videos'))
            $data['disallow'][] = '/galerias-videos';

        if (!$this->config->item('gercont-gerenciar-fotos'))
            $data['disallow'][] = '/galerias-fotos';

        if (!$this->config->item('gercont-gerenciar-catalogo'))
            $data['disallow'][] = '/catalogo';

        if (!$this->config->item('gercont-gerenciar-newsletter'))
            $data['disallow'][] = '/newsletter';

        $this->load->view('robots', $data);
    }

}
