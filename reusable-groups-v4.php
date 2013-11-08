<?php

class acf_field_reusable_group extends acf_field
{
	// vars
	var $settings, // will hold info such as dir / path
		$defaults; // will hold default field options
		
		
	/*
	*  __construct
	*
	*  Set name / label needed for actions / filters
	*
	*  @since	3.6
	*  @date	23/01/13
	*/
	
	function __construct()
	{
		// vars
		$this->name = 'reusable-group';
		$this->label = 'Reusable Group';
		$this->category = __('Reusable Groups','acf');
		$this->defaults = array();
		
		
		// do not delete!
    	parent::__construct();
    	
    	
    	// settings
		$this->settings = array(
			'path' => apply_filters('acf/helpers/get_path', __FILE__),
			'dir' => apply_filters('acf/helpers/get_dir', __FILE__),
			'version' => '1.0.0'
		);
		

	}
	
	
	/*
	*  input_admin_enqueue_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is created.
	*  Use this action to add css + javascript to assist your create_field() action.
	*
	*  $info	http://codex.wordpress.org/Plugin_API/Action_Reference/admin_enqueue_scripts
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/

	function input_admin_enqueue_scripts()
	{

		// register acf styles
		wp_register_style('acf-reusable-group', $this->settings['dir'] . 'css/input.css'); 
		
		// styles
		wp_enqueue_style(array(
			'acf-reusable-group',	
		));
		
	}
	
	
	/*
	*  input_admin_head()
	*
	*  This action is called in the admin_head action on the edit screen where your field is created.
	*  Use this action to add css and javascript to assist your create_field() action.
	*
	*  @info	http://codex.wordpress.org/Plugin_API/Action_Reference/admin_head
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/

	function input_admin_head()
	{

		// register acf styles
	//	wp_register_style('acf-reusable-group-admin', $this->settings['dir'] . 'css/reusable-group-field.css', array('acf-reusable-group'), $this->settings['version']); 
		
		// styles
	//	wp_enqueue_style(array(
	//		'acf-reusable-group-admin',	
	//	));

	}
	
	
	/*
	*  create_options()
	*
	*  Create extra options for your field. This is rendered when editing a field.
	*  The value of $field['name'] can be used (like bellow) to save extra data to the $field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field	- an array holding all the field's data
	*/
	
	function create_options( $field )
	{
		
		// defaults
		$field = array_merge($this->defaults, $field);

		// key is needed in the field names to correctly save the data
		$key = $field['name'];

		$value = isset($field['field_group']) ? $field['field_group'] : NULL;

		$field_groups = acf_field_group::get_field_groups(array());
		$field_group_choices = array();

		foreach ( $field_groups as $field_group ) {

			// we *don't* want to include this field group, that'd cause an infinite loop
			if ( isset($_GET['post']) && $_GET['post'] == $field_group['id'] ) {
				continue;
			}

			$field_group_choices[$field_group['id']] = $field_group['title'];

		}		

		// Create Field Options HTML
		?>

		<tr class="field_option field_option_<?php echo $this->name; ?>">
			<td class="label">
				<label>Field Group</label>
				<p class="description">Select a field group in which to inherit fields from</p>
			</td>
			<td>
				<?php
				do_action('acf/create_field', array(
					'type'	=>	'select',
					'name'	=>	'fields['.$key.'][field_group_id]',
					'required' => TRUE,
					'choices'	=>	$field_group_choices,
					'value' => $field['field_group_id']
				));
				?>
			</td>
		</tr>

		<?php
		
	}
	
	
	/*
	*  create_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field - an array holding all the field's data
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/
	
	function create_field( $field )
	{

		global $post;

		// defaults
		$field = array_merge($this->defaults, $field);

		// get the sub-fields
		$fields = apply_filters('acf/field_group/get_fields', array(), $field['field_group_id']);

		// output the sub-fields
		do_action('acf/create_fields', $fields, $post->ID);

	}
	
}

// create field
new acf_field_reusable_group();