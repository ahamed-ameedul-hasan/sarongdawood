<?php
namespace Razzi\Addons\Elementor\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

/**
 * Icon Box widget
 */
class Team_Member_Carousel extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'razzi-team-member-carousel';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Team Member Carousel', 'razzi-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-carousel';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return ['razzi'];
	}

	/**
	 * Get widget keywords.
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'team member carousel', 'team', 'member', 'carousel', 'razzi-addons' ];
	}

	/**
	 * Register the widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_team_member',
			[ 'label' => __( 'Team Member', 'razzi-addons' ) ]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'image',
			[
				'label' => __( 'Image', 'razzi-addons' ),
				'type' => Controls_Manager::MEDIA,
			]
		);

		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'image',
				'default' => 'full',
				'separator' => 'none',
			]
		);

		$repeater->add_control(
			'name',
			[
				'label' => __( 'Name', 'razzi-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Member name', 'razzi-addons' ),
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'job',
			[
				'label' => __( 'Job', 'razzi-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Member job', 'razzi-addons' )
			]
		);

		// Socials
		$repeater->add_control(
			'socials_toggle',
			[
				'label' => __( 'Socials', 'razzi-addons' ),
				'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
				'label_off' => __( 'Default', 'razzi-addons' ),
				'label_on' => __( 'Custom', 'razzi-addons' ),
				'return_value' => 'yes',
				'separator' => 'before',
			]
		);

		$repeater->start_popover();

		$socials = $this->get_social_icons();

		foreach( $socials as $key => $social ) {
			$repeater->add_control(
				$key,
				[
					'label'       => $social['label'],
					'type'        => Controls_Manager::URL,
					'placeholder' => __( 'https://your-link.com', 'razzi-addons' ),
					'default'     => [
						'url' => '',
					],
				]
			);
		}

		$repeater->end_popover();

		$this->add_control(
			'members',
			[
				'label'       => __( 'Members', 'razzi-addons' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ name }}}',
				'default' => [
					[
						'name' => __( 'Member name #1', 'razzi-addons' ),
						'job'  => __( 'Member job #1', 'razzi-addons' ),
					],
					[
						'name' => __( 'Member name #2', 'razzi-addons' ),
						'job'  => __( 'Member job #2', 'razzi-addons' ),
					],
					[
						'name' => __( 'Member name #3', 'razzi-addons' ),
						'job'  => __( 'Member job #3', 'razzi-addons' ),
					],
					[
						'name' => __( 'Member name #4', 'razzi-addons' ),
						'job'  => __( 'Member job #4', 'razzi-addons' ),
					],
				],
			]
		);

		$this->end_controls_section();

			// Carousel Settings
			$this->start_controls_section(
				'section_carousel_settings',
				[ 'label' => esc_html__( 'Carousel Settings', 'razzi-addons' ) ]
			);

			$this->add_responsive_control(
				'slidesToShow',
				[
					'label'   => esc_html__( 'Slides to show', 'razzi-addons' ),
					'type'    => Controls_Manager::NUMBER,
					'min'     => 1,
					'max'     => 6,
					'desktop_default' => 3,
					'tablet_default' => 2,
					'mobile_default' => 1,
					'frontend_available' => true,
				]
			);
			$this->add_responsive_control(
				'slidesToScroll',
				[
					'label'   => esc_html__( 'Slides to scroll', 'razzi-addons' ),
					'type'    => Controls_Manager::NUMBER,
					'min'     => 1,
					'max'     => 5,
					'desktop_default' => 3,
					'tablet_default' => 2,
					'mobile_default' => 1,
					'frontend_available' => true,
				]
			);

			$this->add_responsive_control(
				'navigation',
				[
					'label'     => esc_html__( 'Navigation', 'razzi-addons' ),
					'type'      => Controls_Manager::SELECT,
					'options' => [
						'none'   => esc_html__( 'None', 'razzi-addons' ),
						'dots' 	 => esc_html__( 'Dots', 'razzi-addons' ),
						'arrows' => esc_html__( 'Arrows', 'razzi-addons' ),
					],
					'default' => 'dots',
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'infinite',
				[
					'label'     => __( 'Infinite', 'razzi-addons' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_off' => __( 'Off', 'razzi-addons' ),
					'label_on'  => __( 'On', 'razzi-addons' ),
					'return_value' => 'yes',
					'default'   => '',
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'autoplay',
				[
					'label'     => __( 'Autoplay', 'razzi-addons' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_off' => __( 'Off', 'razzi-addons' ),
					'label_on'  => __( 'On', 'razzi-addons' ),
					'return_value' => 'yes',
					'default'   => 'yes',
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'autoplay_speed',
				[
					'label'   => __( 'Autoplay Speed (in ms)', 'razzi-addons' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 1000,
					'min'     => 100,
					'step'    => 100,
					'frontend_available' => true,
				]
			);

			$this->end_controls_section(); // End Carousel Settings

		// Content
		$this->start_controls_section(
			'section_items_style',
			[
				'label' => __( 'Items', 'razzi-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		// Name
		$this->add_control(
			'name_style_heading',
			[
				'label'     => __( 'Name', 'razzi-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'name_color',
			[
				'label' => __( 'Color', 'razzi-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .razzi-team-member__name' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'name_typography',
				'selector' => '{{WRAPPER}} .razzi-team-member__name',
			]
		);

		// Job
		$this->add_control(
			'job_style_heading',
			[
				'label'     => __( 'Job', 'razzi-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'job_color',
			[
				'label' => __( 'Color', 'razzi-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .razzi-team-member__job' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'job_typography',
				'selector' => '{{WRAPPER}} .razzi-team-member__job',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Get Team Member Socials
	 */
	protected function get_social_icons() {
		$socials = [
			'facebook' => [
				'icon' => 'fa fa-facebook',
				'label' => __( 'Facebook', 'razzi-addons' )
			],
			'twitter' => [
				'icon' => 'fa fa-twitter',
				'label' => __( 'Twitter', 'razzi-addons' )
			],
			'youtube' => [
				'icon' => 'fa fa-youtube-play',
				'label' => __( 'Youtube', 'razzi-addons' )
			],
			'dribbble' => [
				'icon' => 'fa fa-dribbble',
				'label' => __( 'Dribbble', 'razzi-addons' )
			],
			'instagram' => [
				'icon' => 'fa fa-instagram',
				'label' => __( 'Instagram', 'razzi-addons' )
			],
			'linkedin' => [
				'icon' => 'fa fa-linkedin',
				'label' => __( 'Linkedin', 'razzi-addons' )
			],
			'pinterest' => [
				'icon' => 'fa fa-pinterest-p',
				'label' => __( 'Pinterest', 'razzi-addons' )
			],
		];

		return $socials;
	}

	/**
	 * Render widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['members'] ) ) {
			return;
		}

		$nav        = $settings['navigation'];
		$nav_tablet = empty( $settings['navigation_tablet'] ) ? $nav : $settings['navigation_tablet'];
		$nav_mobile = empty( $settings['navigation_mobile'] ) ? $nav : $settings['navigation_mobile'];

		$this->add_render_attribute( 'wrapper', 'class', [
			'razzi-team-member-carousel',
			'razzi-swiper-carousel-elementor',
			'swiper-container',
			'navigation-' . $nav,
			'navigation-tablet-' . $nav_tablet,
			'navigation-mobile-' . $nav_mobile,
		] );

		if ( is_rtl() ) {
			$this->add_render_attribute( 'wrapper', 'dir', 'rtl' );
		}

		$socials = $this->get_social_icons();
		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php
			echo \Razzi\Addons\Helper::get_svg( 'chevron-left','rz-swiper-button-prev rz-swiper-button' );
			echo \Razzi\Addons\Helper::get_svg( 'chevron-right','rz-swiper-button-next rz-swiper-button' );
			?>
			<div class="razzi-team-member__list swiper-wrapper">
				<?php foreach( $settings['members'] as $index => $member ) : ?>
					<div class="razzi-team-member swiper-slide">
						<?php
						if ( $member['image']['url'] ) {
							echo Group_Control_Image_Size::get_attachment_image_html( $member );
						}
						?>
						<div class="razzi-team-member__info">
							<h5 class="razzi-team-member__name"><?php echo esc_html( $member['name'] ) ?></h5>
							<span class="razzi-team-member__job"><?php echo esc_html( $member['job'] ) ?></span>
							<span class="razzi-team-member__socials">
								<?php
								foreach( $socials as $key => $social ) {
									if ( empty( $member[ $key ]['url'] ) ) {
										continue;
									}

									$link_key = $this->get_repeater_setting_key( 'link', 'social', $key );
									$this->add_link_attributes( $link_key, $member[ $key ] );
									$this->add_render_attribute( $link_key, 'title', $social['label'] );
									?>
									<a <?php echo $this->get_render_attribute_string( $link_key ); ?>>
										<i class="<?php echo esc_attr( $social['icon'] ) ?>"></i>
									</a>
									<?php
								}
								?>
							</span>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="swiper-pagination"></div>
		</div>
		<?php
	}
}