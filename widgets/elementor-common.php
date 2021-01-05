<?php
/**
 * EWA Elementor Heading Widget.
 *
 * Elementor widget that inserts heading into the page
 *
 * @since 1.0.0
 */
class Elementor_Common_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve heading  widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ewa-ashley-heading-widget';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve heading widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'EWA Ashley Heading', 'ewa-elementor-ashley' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve heading  widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'far fa-address-card';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the heading widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'elementor-common' ];
	}

	/**
	 * Register heading widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {
		
		// start of the Content tab section
	   $this->start_controls_section(
	       'content-section',
		    [
		        'label' => esc_html__('Content','ewa-elementor-ashley'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		   
		    ]
	    );
		
		// Heading Title
		$this->add_control(
		    'ewa_heading_title',
			[
			    'label' => esc_html__('Title','ewa-elementor-ashley'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__('Enter Heading Title','ewa-elementor-ashley'),
			]
		);
		
		// Heading Description
		$this->add_control(
		    'ewa_heading_des',
			[
			    'label' => esc_html__('Description','ewa-elementor-ashley'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'label_block' => true,
				'placeholder' => esc_html__('Enter Heading Description','ewa-elementor-ashley'),
			]
		);
		
		$this->end_controls_section();
		// end of the Content tab section
		
		// start of the Style tab section
		$this->start_controls_section(
			'style_section',
			[
				'label' => esc_html__( 'Content Style', 'ewa-elementor-ashley' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->start_controls_tabs(
			'style_tabs'
		);
		
		// start everything related to Normal state here
		$this->start_controls_tab(
			'style_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'ewa-elementor-ashley' ),
			]
		);
		
		// Heading Title Options
		$this->add_control(
			'ewa_heading_title_options',
			[
				'label' => esc_html__( 'Title', 'ewa-elementor-ashley' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		// Heading Title Color
		$this->add_control(
			'ewa_heading_title_color',
			[
				'label' => esc_html__( 'Color', 'ewa-elementor-ashley' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'default' => '#1D282E',
				'selectors' => [
					'{{WRAPPER}} .section-heading__title' => 'color: {{VALUE}}',
				],
			]
		);

		// Heading Title Typography
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'ewa_heading_title_typography',
				'label' => esc_html__( 'Typography', 'ewa-elementor-ashley' ),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .section-heading__content h5',
			]
		);
        
		// Heading Description Options
		$this->add_control(
			'ewa_heading_des_options',
			[
				'label' => esc_html__( 'Description', 'ewa-elementor-ashley' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		// Heading Description Color
		$this->add_control(
			'ewa_heading_des_color',
			[
				'label' => esc_html__( 'Color', 'ewa-elementor-ashley' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'default' => '#1D282E',
				'selectors' => [
					'{{WRAPPER}} .section-heading__description' => 'color: {{VALUE}}',
				],
			]
		);

		// Heading Description Typography
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'ewa_heading_desc_typography',
				'label' => esc_html__( 'Typography', 'ewa-elementor-ashley' ),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .section-heading__content p',
			]
		);
		
		$this->end_controls_tab();
		// end everything related to Normal state here

		// start everything related to Hover state here
		$this->start_controls_tab(
			'style_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'ewa-elementor-ashley' ),
			]
		);
		
		$this->end_controls_tab();
		// end everything related to Hover state here

		$this->end_controls_tabs();

		$this->end_controls_section();
		// end of the Style tab section

	}

	/**
	 * Render heading  widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		// get our input from the widget settings.
		$settings = $this->get_settings_for_display();
		
		$heading_title = $settings['ewa_heading_title'];
		$heading_description = $settings['ewa_heading_des'];
		
		
		?>
		
		<!-- Heading Area Start Here -->		
		    <div class="section-heading">
			    <div class="section-heading__content">
				    <h5 class="section-heading__title"><?php echo $heading_title; ?></h5>
					<p class="section-heading__description"><?php echo $heading_description; ?></p>
				</div> <!-- .section-heading__content end here -->
			</div>
		<!-- Heading Area End Here -->
       <?php
	}
}