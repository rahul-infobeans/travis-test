// import { registerBlockType } from '@wordpress/blocks';
( function() {
	// import { useBlockProps } from '@wordpress/block-editor';
	var registerBlockType = wp.blocks.registerBlockType;

registerBlockType( 'gb/basic-01', {
	title: 'GB Basic',
	icon: 'shield-alt',
	category: 'common',
	
	edit: function( props ) {
					return wp.element.createElement(
			'p',
			{ className: props.className },
			'Hello World! — from the editor (01 Basic Block).'
		);
	},

} );

registerBlockType( 'create-block/gutenpride', {
    apiVersion: 2,
    title: 'Gutenpride',
    description: 'Example block.',
    category: 'widgets',
    icon: 'smiley',
    supports: {
        // Removes support for an HTML mode.
        html: false,
    },
 
    edit: () => {
        const blockProps = wp.blockEditor.useBlockProps();
        return '<div { ...blockProps }> Hello in Editor. </div>';
    },
 
    save: () => {
        const blockProps = wp.blockEditor.useBlockProps.save();
        return '<div { ...blockProps }> Hello in Save.</div>';
    },
} );
})();