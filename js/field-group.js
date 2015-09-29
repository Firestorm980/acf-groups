(function($){
	
	var group = {
		
		$el : null,
		
		set : function( o ){
			
			// merge in new option
			$.extend( this, o );
			
				
			// return this for chaining
			return this;
			
		},
		
		init : function(){
			
			this.render();
			
		},
		
		render : function(){
			
			// vars
			var id = this.$el.attr('data-id'),
				layout = 'table';
			
			
			// find layout value
			if( this.$el.find('input[name="fields[' + id + '][layout]"]:checked').length > 0 )
			{
				layout = this.$el.find('input[name="fields[' + id + '][layout]"]:checked').val();
			}
			
			
			// add class
			this.$el.find('.group:first').removeClass('layout-row layout-table').addClass( 'layout-' + layout );
			
		}
		
	};
	
	
	/*
	*  Document Ready
	*
	*  description
	*
	*  @type	function
	*  @date	18/08/13
	*
	*  @param	$post_id (int)
	*  @return	$post_id (int)
	*/
	
	$(document).ready(function(){
		
		$('.field_type-group').each(function(){
			
			group.set({ $el : $(this) }).init();
			
		});
		
	});
	
	
	/*
	*  Events
	*
	*  jQuery events for this field
	*
	*  @type	function
	*  @date	1/03/2011
	*
	*  @param	N/A
	*  @return	N/A
	*/
	
	$(document).on('click', '.field_option_group_layout input[type="radio"]', function( e ){
		
		group.set({ $el : $(this).closest('.field_type-group') }).render();
		
	});
	
	
	$(document).on('acf/field_form-open', function(e, field){
		
		// vars
		$el = $(field);
		
		
		if( $el.hasClass('field_type-group') )
		{
			group.set({ $el : $el }).render();
		}
		
	});
	

})(jQuery);
