<?php

	if (!class_exists('Timber')){
		add_action( 'admin_notices', function(){
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . admin_url('plugins.php#timber') . '">' . admin_url('plugins.php') . '</a></p></div>';
		});
		return;
	}

	class StarterSite extends TimberSite {

		function __construct(){
			add_theme_support('post-formats');
			add_theme_support('post-thumbnails');
			add_theme_support('menus');
			add_filter('timber_context', array($this, 'add_to_context'));
			add_filter('get_twig', array($this, 'add_to_twig'));
			add_filter('comment_form_default_fields', array($this, 'bootstrap3_comment_form_fields'));
			add_filter('comment_form_defaults',array($this, 'bootstrap3_comment_form') );
			add_action('comment_form',array($this, 'bootstrap3_comment_button') );

			add_action('init', array($this, 'register_post_types'));
			add_action('init', array($this, 'register_taxonomies'));

			parent::__construct();
		}

		function bootstrap3_comment_form_fields( $fields ) {
			$commenter = wp_get_current_commenter();

			$req      = get_option( 'require_name_email' );
			$aria_req = ( $req ? " aria-required='true'" : '' );
			$html5    = current_theme_supports( 'html5', 'comment-form' ) ? 1 : 0;

			$fields   =  array(
				'author' => '<div class="form-group comment-form-author">' .
					'<input class="form-control" placeholder="Name" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></div>',
				'email'  => '<div class="form-group comment-form-email">' .
					'<input class="form-control" placeholder="Email" id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></div>',
				'url'    => '<div class="form-group comment-form-url">' .
					'<input class="form-control" placeholder="Website" id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></div>',
			);

			return $fields;
		}

		function bootstrap3_comment_form( $args ) {
			$args['comment_field'] = '<div class="form-group comment-form-comment">
            <textarea placeholder="Comment" class="form-control" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>
        </div>';
			return $args;
		}

		function bootstrap3_comment_button() {
			echo '<button class="btn btn-default" type="submit">' . __( 'Submit' ) . '</button>';
		}

		function register_post_types(){
			//this is where you can register custom post types
		}

		function register_taxonomies(){
			//this is where you can register custom taxonomies
		}

		function add_to_context($context){
			$context['foo'] = 'bar';
			$context['stuff'] = 'I am a value set in your functions.php file';
			$context['notes'] = 'These values are available everytime you call Timber::get_context();';
			$context['menu'] = new TimberMenu();
			$context['site'] = $this;
			return $context;
		}

		function add_to_twig($twig){
			/* this is where you can add your own fuctions to twig */
			$twig->addExtension(new Twig_Extension_StringLoader());
			$twig->addFilter('myfoo', new Twig_Filter_Function('myfoo'));
			return $twig;
		}

	}

	new StarterSite();

	function myfoo($text){
    	$text .= ' bar!';
    	return $text;
	}