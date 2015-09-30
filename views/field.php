<?php

// validate 
// value may be false
if( !is_array($field['value']) )
{
	$field['value'] = array();
}

// populate values

foreach( $field['sub_fields'] as $sub_field )
{
	
	if ( !isset($field['value'][ 0 ][ $sub_field['key'] ]) ){

		$sub_value = false;

		if ( !empty($sub_field['default_value']) ){
			$sub_value = $sub_field['default_value'];
		}

		$field['value'][ 0 ][ $sub_field['key'] ] = $sub_value;	
	}
}

// setup values for row clone
$field['value']['acfcloneindex'] = array();
foreach( $field['sub_fields'] as $sub_field )
{
	$sub_value = false;
			
	if( isset($sub_field['default_value']) )
	{
		$sub_value = $sub_field['default_value'];
	}

	$field['value']['acfcloneindex'][ $sub_field['key'] ] = $sub_value;
}


// helper function which does not exist yet in acf
if( !function_exists('acf_get_join_attr') ):

function acf_get_join_attr( $attributes = false )
{
	// validate
	if( empty($attributes) )
	{
		return '';
	}
	
	
	// vars
	$e = array();
	
	
	// loop through and render
	foreach( $attributes as $k => $v )
	{
		$e[] = $k . '="' . esc_attr( $v ) . '"';
	}
	
	
	// echo
	return implode(' ', $e);
}

endif;

if( !function_exists('acf_join_attr') ):

function acf_join_attr( $attributes = false )
{
	echo acf_get_join_attr( $attributes );
}

endif;

?>
<div class="group">
	<table class="widefat acf-input-table row_layout">
	<tbody>
	<?php if( $field['value'] ): foreach( $field['value'] as $i => $value ): ?>
		<tr class="<?php echo ( (string) $i == 'acfcloneindex') ? "row-clone" : "row"; ?>">
			<td class="acf_input-wrap">
				<table class="widefat acf_input">
		<?php foreach( $field['sub_fields'] as $sub_field ): ?>
		
			<?php
			
			// attributes 
			$attributes = array(
				'class'				=> "field sub_field field_type-{$sub_field['type']} field_key-{$sub_field['key']}",
				'data-field_type'	=> $sub_field['type'],
				'data-field_key'	=> $sub_field['key'],
				'data-field_name'	=> $sub_field['name']
			);
			
			// required
			if( $sub_field['required'] )
			{
				$attributes['class'] .= ' required';
			}

			?>
				<tr <?php acf_join_attr( $attributes ); ?>>
					<td class="label">
						<label>
							<?php echo $sub_field['label']; ?>
							<?php if( $sub_field['required'] ): ?><span class="required">*</span><?php endif; ?>
						</label>
						<?php if( isset($sub_field['instructions']) ): ?>
							<span class="sub-field-instructions"><?php echo $sub_field['instructions']; ?></span>
						<?php endif; ?>
					</td>
			
					<td>
						<div class="inner">
						<?php
							
						// prevent repeater field from creating multiple conditional logic items for each row
						if( $i !== 'acfcloneindex' )
						{
							$sub_field['conditional_logic']['status'] = 0;
							$sub_field['conditional_logic']['rules'] = array();
						}
						
						// add value
						$sub_field['value'] = isset($value[$sub_field['key']]) ? $value[$sub_field['key']] : '';
							
						// add name
						$sub_field['name'] = $field['name'] . '[' . $i . '][' . $sub_field['key'] . ']';
						
						// clear ID (needed for sub fields to work!)
						unset( $sub_field['id'] );
						
						// create field
						do_action('acf/create_field', $sub_field);
						
						?>
						</div>
					</td>
				</tr>
		<?php endforeach; ?>
				</table>
			</td>
		</tr>
	<?php endforeach; endif; ?>
	</tbody>
	</table>
</div>