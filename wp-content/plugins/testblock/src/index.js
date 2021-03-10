/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/#registering-a-block
 */
import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps,RichText, InnerBlocks } from '@wordpress/block-editor';
import { TextControl } from '@wordpress/components';
/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * All files containing `style` keyword are bundled together. The code used
 * gets applied both to the front of your site and to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './style.scss';

/**
 * Internal dependencies
 */
import Edit from './edit';
import save from './save';

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/#registering-a-block
 */
registerBlockType( 'create-block/testblock', {
	/**
	 * @see https://make.wordpress.org/core/2020/11/18/block-api-version-2/
	 */
	apiVersion: 2,

	/**
	 * This is the display title for your block, which can be translated with `i18n` functions.
	 * The block inserter will show this name.
	 */
	title: __( 'Testblock', 'testblock' ),

	/**
	 * This is a short description for your block, can be translated with `i18n` functions.
	 * It will be shown in the Block Tab in the Settings Sidebar.
	 */
	description: __(
		'Example block written with ESNext standard and JSX support – build step required.',
		'testblock'
	),

	/**
	 * Blocks are grouped into categories to help users browse and discover them.
	 * The categories provided by core are `text`, `media`, `design`, `widgets`, and `embed`.
	 */
	category: 'widgets',

	/**
	 * An icon property should be specified to make it easier to identify a block.
	 * These can be any of WordPress’ Dashicons, or a custom svg element.
	 */
	icon: 'smiley',

	/**
	 * Optional block extended support features.
	 */
	supports: {
		// Removes support for an HTML mode.
		html: false,
	},

	/**
	 * @see ./edit.js
	 */
	edit: Edit,

	/**
	 * @see ./save.js
	 */
	save,
} );

registerBlockType( 'create-block/newblock', {
	title: __( 'New block', 'newblock' ),
	attributes: {
		message: {
			type: 'string',
			source: 'text',
			selector: 'div',
		},
	},
	// description: __(
	// 	'Example block written with ESNext standard and JSX support – build step required.',
	// 	'testblock'
	// ),
	category: 'widgets',
	icon: 'smiley',
	supports: {
		html: false,
	},
	edit: ( { attributes, setAttributes, isSelected } ) => {
		const blockProps = useBlockProps();
		const { content, mySetting } = attributes;
		const toggleSetting = () => setAttributes( { mySetting: ! mySetting } );
		return (
			<div { ...blockProps }>
			
			<TextControl
                label={ __( 'Message', 'gutenpride' ) }
                value={ attributes.message }
                onChange={ ( val ) => setAttributes( { message: val } ) }
            />
		</div>
		);
	},
	save: ( { attributes, className }) => <div className={ className }>{ attributes.message }</div>,
} );


registerBlockType( 'create-block/block-one', {
	title: __( 'Block1', 'block-one' ),
	attributes: {
		content: {
			type: 'array',
			source: 'children',
			selector: 'p',
		},
	},
	// description: __(
	// 	'Example block written with ESNext standard and JSX support – build step required.',
	// 	'testblock'
	// ),
	category: 'design',
	icon: 'universal-access-alt',
	example: {
        attributes: {
            content: 'Hello World',
        },
    },
    edit: ( props ) => {
        const { attributes: { content }, setAttributes, className } = props;
        const blockProps = useBlockProps();
        const onChangeContent = ( newContent ) => {
            setAttributes( { content: newContent } );
        };
        return (
            <RichText
                { ...blockProps }
                tagName="p"
                onChange={ onChangeContent }
                value={ content }
            />
        );
    },
    save: ( props ) => {
        const blockProps = useBlockProps.save();
        return <RichText.Content { ...blockProps } tagName="p" value={ props.attributes.content } />;
    },
} );

import {AlignmentToolbar,BlockControls, InspectorControls} from '@wordpress/block-editor';
import {PanelBody, PanelRow, FormToggle} from '@wordpress/components'
registerBlockType( 'create-block/block-two', {
	title: __( 'Block 2', 'block-two' ),
	attributes: {
        content: {
            type: 'array',
            source: 'children',
            selector: 'p',
        },
        alignment: {
            type: 'string',
            default: 'none',
		},
		highContrast: {
			type: 'boolean',
			default: false,
		}
    },
	// description: __(
	// 	'Example block written with ESNext standard and JSX support – build step required.',
	// 	'testblock'
	// ),
	category: 'design',
	icon: 'universal-access-alt',
	example: {
        attributes: {
            content: 'Hello World',
        },
    },
    edit: ( props ) => {
        const {
            attributes: {
                content,
				alignment,
				highContrast,
			},
			className
        } = props;
 
        const blockProps = useBlockProps();
 
        const onChangeContent = ( newContent ) => {
            props.setAttributes( { content: newContent } );
        };
 
        const onChangeAlignment = ( newAlignment ) => {
            props.setAttributes( { alignment: newAlignment === undefined ? 'none' : newAlignment } );
		};
		const toggleHighContrast = (contrast) => { props.setAttributes({ highContrast: contrast})  }
 
        return (
            <div {...blockProps}>
                {
					<InspectorControls>
						<PanelBody title={ __( 'High Contrast', 'jsforwpblocks' ) } >
							<PanelRow>
							<label
								htmlFor="high-contrast-form-toggle"
							>
								{ __( 'High Contrast', 'jsforwpblocks' ) }
							</label>  
							<FormToggle
								id="high-contrast-form-toggle"
								label={ __( 'High Contrast', 'jsforwpblocks' ) }
								checked={ highContrast }
								onChange={ toggleHighContrast }
							/> 
							</PanelRow>
						</PanelBody>
				</InspectorControls>
				}
				{
                    <BlockControls>
                        <AlignmentToolbar
                            value={ alignment }
                            onChange={ onChangeAlignment }
                        />
                    </BlockControls>
                }
                <RichText
                    className={ className }
                    style={ { textAlign: alignment } }
                    tagName="p"
                    onChange={ onChangeContent }
                    value={ content }
                />
            </div>
        );
    },
    save: ( props ) => {
        const blockProps = useBlockProps.save();
 
        return (
            <div {...blockProps}>
                <RichText.Content
                    className={ `gutenberg-examples-align-${ props.attributes.alignment }` }
                    tagName="p"
                    value={ props.attributes.content }
                />
            </div>
        );
    },
} );

import { withSelect } from '@wordpress/data';
import ServerSideRender from '@wordpress/server-side-render';
 
registerBlockType( 'create-block/example-dynamic', {
    apiVersion: 2,
    title: 'Example: last post',
    icon: 'megaphone',
    category: 'widgets',
 //This is client-side rendering
    // edit: withSelect( ( select ) => {
    //     return {
    //         posts: select( 'core' ).getEntityRecords( 'postType', 'post' ),
    //     };
    // } )( ( { posts } ) => {
    //     const blockProps = useBlockProps();
 
    //     return (
    //         <div { ...blockProps }>
    //             { ! posts && 'Loading' }
    //             { posts && posts.length === 0 && 'No Posts' }
    //             { posts && posts.length > 0 && (
    //                 <a href={ posts[ 0 ].link }>
    //                     { posts[ 0 ].title.rendered }
    //                 </a>
    //             ) } 
    //         </div>
    //     )
 
	// } ),
// This is server side rendering
edit: function( props ) {
	const blockProps = useBlockProps();
	return (
		<div {...blockProps}>
			<ServerSideRender
				block="create-block/example-dynamic"
				attributes={ props.attributes }
			/>
		</div>
	);
},
} );


registerBlockType( 'create-block/example-06', {
    apiVersion: 2,
    title: 'Example: Inner blocks',
    icon: 'megaphone',
    category: 'widgets',
 
    edit: () => {
        const blockProps = useBlockProps();
		const ALLOWED_BLOCKS = [ 'core/image', 'core/paragraph' ];
		const MY_TEMPLATE = [
			[ 'core/image', {} ],
			[ 'core/heading', { placeholder: 'Book Title' } ],
			[ 'core/paragraph', { placeholder: 'Summary' } ],
		];
        return (
            <div { ...blockProps }>
				<FormToggle
								id="high-contrast-form-toggle"
								label={ __( 'High Contrast', 'jsforwpblocks' ) }
								checked={ true }
								
							/> 
				<InnerBlocks 
					template={ MY_TEMPLATE }
					templateLock="insert"
					allowedBlocks={ALLOWED_BLOCKS} />
            </div>
        );
    },
 
    save: () => {
        const blockProps = useBlockProps.save();
 
        return (
            <div { ...blockProps }>
                <InnerBlocks.Content />
            </div>
        );
    },
} );
 
//import Meta from './metabox'


import { useSelect } from '@wordpress/data';
import { useEntityProp } from '@wordpress/core-data';
 
registerBlockType( 'create-block/meta-block', {
    title: 'Meta Block',
    icon: 'smiley',
    category: 'text',
 
    edit( { setAttributes, attributes } ) {
        const blockProps = useBlockProps();
        const postType = useSelect(
            ( select ) => select( 'core/editor' ).getCurrentPostType(),
            []
		);
        const [ meta, setMeta ] = useEntityProp(
            'postType',
            postType,
            'meta'
		);
		//console.log('posttype', postType, 'Meta', meta, 'setmeta', setMeta);
		
        const metaFieldValue = meta['myguten_meta_block_field'];
        function updateMetaValue( newValue ) {
            setMeta( { ...meta, 'myguten_meta_block_field': newValue } );
        }
 
        return (
            <div { ...blockProps }>
                <TextControl
                    label="Meta Block Field"
                    value={ metaFieldValue }
                    onChange={ updateMetaValue }
                />
            </div>
        );
    },
 
    // No information saved to the block
    // Data is saved to post meta via the hook
    save() {
        return null;
    },
} );