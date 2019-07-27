jQuery( function( $ ) {
	"use strict";
	var $window = $( window );
	var $document = $( document );
	var $body = $( 'body' );
	space.themeEnabled = parseInt( space.themeEnabled, 10 );
	space.spaceEnabled = parseInt( space.spaceEnabled, 10 );


	if ( space.spaceEnabled && space.themeEnabled ) {

		$( '.space-theme #dashboard_quick_press' ).find( '#title' ).attr( 'placeholder', $.trim( $( this ).find( '#title-prompt-text' ).text() ) );
		$( '.space-theme #dashboard_quick_press' ).find( '#content' ).attr( 'placeholder', $.trim( $( this ).find( '#content-prompt-text' ).text() ) );
		$( '.space-theme.post-php, .space-theme.post-new-php' ).find( '#title' ).attr( 'placeholder', $.trim( $( '#title-prompt-text' ).text() ) );

	}


	/* screen help */
	if ( space.spaceEnabled && space.themeEnabled ) {
		window.screenMeta = {
			init: function() {}
		};
		// 4.2
		$( '.screen-meta-toggle a' ).each( function() {
			var $this = $( this ).addClass( 'thickbox thickbox--space' );
			var width = 600;
			var height = 400;
			var target = $this.attr( 'href' ).substring( 1 );
			$this.attr( 'href', '#TB_inline?width=' + width + '&height=' + height + '&inlineId=' + target );
			if ( $this.is( $( '#show-settings-link' ) ) ) {
				$this.attr( 'title', space.L10n.screenOptions );
			}
			if ( $this.is( $( '#contextual-help-link' ) ) ) {
				$this.attr( 'title', space.L10n.help );
			}
		} );
		// WP 4.3+
		if ( $( '.screen-meta-toggle button' ).length ) {
			$( '#show-settings-link' ).on( 'click', function() {
				tb_show( space.L10n.screenOptions, '#TB_inline?inlineId=screen-options-wrap' );
			} );
			$( '#contextual-help-link' ).on( 'click', function() {
				tb_show( space.L10n.help, '#TB_inline?inlineId=contextual-help-wrap' );
			} );
		}
	}

	setTimeout( function() {
		$( 'body' ).off( 'thickbox:removed' );
	}, 100 );

	// reset all
	$( '.space-options-revert-button' ).on( 'click', function( e ) {

		e.preventDefault();

		if ( confirm( space.L10n.revertConfirm ) ) {
			$( '.space-options-form' ).prepend( '<input type="hidden" name="' + space.options_slug + '[space-revert-page]" value="1" />' );
			$( '.space-options-save-button' ).trigger( 'click' );
		}

	});

	// menus
	function space_process_admin_menu_editor() {

		var $menu_list = $(' .space-admin-menu-editor ');
		var data;

		$menu_list.find(':checkbox:disabled').prop( 'disabled', false ).addClass( '-disabled' );
		$menu_list.find(':checkbox:not(:checked)').attr( 'value', '0' ).prop( 'checked', true ).addClass( '-unchecked' );

		data = $menu_list.find( ':input' ).serializeArray();
		data = JSON.stringify( data );

		$menu_list.find( '.-disabled' ).prop( 'disabled', true ).removeClass( '-disabled' );
		$menu_list.find( '.-unchecked' ).attr( 'value', '1' ).prop( 'checked', false ).removeClass( '-unchecked' );

		$( '#space-formfield-admin-menu' ).val( data );

	}

	// sortable
	$( '.space-admin-menu-editor-mainmenu' ).sortable( {
		cancel: '.space-admin-menu-editor-item-edit, .space-admin-menu-editor-item-settings, .space-admin-menu-editor-submenu',
		placeholder: 'sortable-placeholder',
		update: function() {

			window.onbeforeunload = function() {
				return space.L10n.saveAlert;
			};
			space_process_admin_menu_editor();

		}
	} );

	$document.on( 'click', '.space-admin-menu-editor-item-settings', function( e ) {
		e.stopPropagation();
	} );

	$( '.space-admin-menu-save-button' ).on( 'click', function() {

		window.onbeforeunload = null;

	} );

	$( '.space-admin-menu-revert-button' ).on( 'click', function( e ) {

		e.preventDefault();

		if ( confirm( space.L10n.revertConfirm ) ) {
			// Empty the form value & submit the form
			$( '#space-formfield-admin-menu' ).val( '' );
			$( '.space-admin-menu-save-button' ).trigger( 'click' );
		}

	});

	$( '.space-admin-menu-editor' ).on( 'change blur', 'input', function( e ) {
		space_process_admin_menu_editor();
	} );

	// widgets
	$( '.space-admin-widget-revert-button' ).on( 'click', function( e ) {

		e.preventDefault();

		if ( confirm( space.L10n.revertConfirm ) ) {
			$( '.space-admin-widget-manager-form' ).prepend( '<input type="hidden" name="' + space.options_slug + '[space-revert-page]" value="1" />' );
			$( '.space-admin-widget-save-button' ).trigger( 'click' );
		}

	});

	// columns
	$( '.space-admin-column-revert-button' ).on( 'click', function( e ) {

		e.preventDefault();

		if ( confirm( space.L10n.revertConfirm ) ) {
			$( '.space-admin-column-manager-form' ).prepend( '<input type="hidden" name="' + space.options_slug + '[space-revert-page]" value="1" />' );
			$( '.space-admin-column-save-button' ).trigger( 'click' );
		}

	});

	// img upload

	$( '.space-media-select-button' ).on( 'click', function( e ) {

		e.preventDefault();
		var $this = $( this );
		var $input = $( '#' + this.id.replace( '-upload-button', '' ) );
		var $preview = $( '#' + this.id.replace( '-upload-button', '-preview' ) );
		var $preview_image = $( '#' + this.id.replace( '-upload-button', '-preview-image' ) );

		wp.media.editor.send.attachment = function( props, attachment ) {
			$input.val( attachment.url );
			$preview_image.attr( 'src', attachment.url );
			$preview.hide().fadeIn( 300 );
		};

		wp.media.editor.open();

	} );

	$( '.space-media-select-clear-button' ).on( 'click', function( e ) {
		e.preventDefault();
		$( this ).siblings( '.space-form-image-input' ).first().val( '' );
		$( this ).siblings( '.space-form-image-preview' ).hide();
	} );

	// Submenu
	function toggle_submenu( element ) {
		var $menu_a = $( element );
		var $menu_li = $menu_a.parents( 'li' );
		$menu_li.toggleClass( 'open' );
	}

	if ( space.spaceEnabled && space.themeEnabled ) {

		$( '#collapse-menu #collapse-button' ).on( 'click', function( e ) {
			$body.toggleClass( 'space-menu-toggled' );
		} );

		var throttle = false;
		$window.on( 'resize', function() {
			if ( throttle ) {
				clearTimeout( throttle );
			}
			throttle = setTimeout( function() {

				$body.removeClass( 'space-menu-toggled' );

				$( '#adminmenu > li.open' ).removeClass( 'open' );

			}, 100 );
		} );

		$( '#toplevel_page_space-menu-collapse > a, #wp-admin-bar-space-menu-expand' ).on( 'click', function( e ) {

			e.preventDefault();

			$( '#collapse-menu #collapse-button' ).trigger( 'click' );

			$( this ).blur();

		} );

		// Toggle submenu on click / space/enter keys
		$( '.wp-has-submenu > a' )
			.on( 'keydown', function( e ) {
				if ( e.keyCode === 32 || e.keyCode === 13 ) { // Space or Enter
					if ( $body.hasClass( 'space-inline-submenus' ) || $window.innerWidth() < ( $( '#adminmenuwrap' ).innerWidth() * 2 ) ) {
						e.preventDefault();
						toggle_submenu( this );
					}
				}
			} )
			.on( 'click', function( e ) {
				if ( $body.hasClass( 'space-inline-submenus' ) || $window.innerWidth() < ( $( '#adminmenuwrap' ).innerWidth() * 2 ) ) {
					e.preventDefault();
					toggle_submenu( this );
					$( this ).blur();
				}
			} );

		$document.on( 'click', '#adminmenu > li > a', function( e ) {
			$( this ).blur();
		} );

		$( '#adminmenu' ).data( 'wp-responsive', false );

		$( 'li.wp-has-submenu' ).on( 'mouseenter', function( e ) {

			if ( $body.hasClass( 'space-menu-hover-expand' ) && $window.innerWidth() >= $( '#adminmenuwrap' ).innerWidth() * 2 ) {

				var $li = $( this );
				var $submenu = $li.children( '.wp-submenu' );
				var submenu_height = $submenu.outerHeight();
				var parent_top = $li.position().top; 
				var window_height = $window.innerHeight();
				var bleed = ( parent_top + submenu_height ) > window_height;

				// inline
				//if ( submenu_height > window_height ) {
				//	$body.removeClass( 'space-menu-hover-expand' ).addClass( 'space-inline-submenus' );
				//}
				//else {
					if ( ! bleed ) {
						$submenu.removeClass( '-up' ).css( { top: parent_top } );
					}
					if ( bleed ) {
						$submenu.addClass( '-up' ).css( { top: parent_top - submenu_height } );
					}

				//}

			}

		} );

	}

	// highlight
	if ( space.spaceEnabled && space.themeEnabled ) {

		$( '.space-theme #dashboard_quick_press' ).on( 'change keyup', ':input:not([type="submit"])', function() {

			var $button = $( '#save-post' );
			if ( $( '#title' ).val() || $( '#content' ).val() ) {
				$button.addClass( 'space-button-highlighted' );
			}
			else {
				$button.removeClass( 'space-button-highlighted' );
			}

		} );

		$( '.space-theme .bulkactions' ).on( 'change', 'select', function() {

			var $select = $( this );
			var $button = $select.siblings( '.button' );
			if ( $select.val() !== '-1' ) {
				$select.addClass( 'space-input-changed' );
				$button.addClass( 'space-button-highlighted' );
			}
			else {
				$select.removeClass( 'space-input-changed' );
				$button.removeClass( 'space-button-highlighted' );
			}

		} );

		$( '.space-theme .filter-items select' ).on( 'change', function() {

			var $selects = $( this ).parents( '.filter-items' ).find( 'select' );
			var $select = $( this );
			var $button = $select.next( '.actions' ).length ? $select.next( '.actions' ).children( '.button' ) : $select.siblings( '.button' );
			var vals = '0';

			if ( $select.val() && $select.val() !== '0' && $select.val() !== '-1' ) {
				$select.addClass( 'space-input-changed' );
			}
			else {
				$select.removeClass( 'space-input-changed' );
			}

			$selects.each( function( i ) {
				var $select = $( this );
				if ( $select.val() !== '0' && $select.val() !== '-1' && $select.val() !== '' ) {
					vals += '1';
				}
			} );
			if ( vals !== '0' ) {
				$button.addClass( 'space-button-highlighted' );
			}
			else {
				$button.removeClass( 'space-button-highlighted' );
			}

		} ).trigger( 'change' );

		$( '.space-theme .tablenav .bulkactions + .actions' ).on( 'change', 'select', function() {

			var $select = $( this );
			var $selects = $select.add( $select.siblings( 'select' ) );
			var $button = $select.siblings( '.button' );
			var vals = '0';

			if ( $select.val() && $select.val() !== '0' && $select.val() !== '-1' ) {
				$select.addClass( 'space-input-changed' );
			}
			else {
				$select.removeClass( 'space-input-changed' );
			}

			$selects.each( function( i ) {
				var $select = $( this );
				if ( $select.val() !== '0' && $select.val() !== '-1' && $select.val() !== '' ) {
					vals += '1';
				}
			} );
			if ( vals !== '0' ) {
				$button.addClass( 'space-button-highlighted' );
			}
			else {
				$button.removeClass( 'space-button-highlighted' );
			}

		} );

		// search
		/*
		$( '.space-theme .search-box' ).on( 'change keyup blur', '[type="search"]', function() {
			var $input = $( this );
			var $button = $input.siblings( '.button' );
			if ( $input.val() ) {
				$button.addClass( 'space-button-highlighted' );
			}
			else {
				$button.removeClass( 'space-button-highlighted' );
			}
		} );
		*/

		// dlt
		$( '.space-theme #documentation' ).on( 'change', 'select', function() {

			var $select = $( this );
			var $button = $select.siblings( '.button' );
			if ( $select.val() ) {
				$select.addClass( 'space-input-changed' );
				$button.addClass( 'space-button-highlighted' );
			}
			else {
				$select.removeClass( 'space-input-changed' );
				$button.removeClass( 'space-button-highlighted' );
			}

		} );

	}

	// scroll
	function scrollto( y_position ) {
		y_position = y_position || 0;
		y_position = y_position < 0 ? 0 : y_position;
		$( 'html, body' ).stop().animate( { scrollTop: y_position }, 600 );
	}

	$( '[data-scrollto]' ).on( 'click', function( e ) {
		var href = $( this ).attr( 'href' );
		var $target;

		if ( href === '#top' ) {
			$target = $( 'body' );
		}

		else {
			$target = $( href );
		}

		if ( ! $target.length ) {
			$target = $( '[name="' + href.replace( '#', '' ) + '"]' );
		}

		if ( $target.length ) {
			e.preventDefault();
			scrollto( $target.offset().top - 100 );
		}

	} );

	$( '[data-js-relay]' ).on( 'click', function( e ) {
		var $this = $( this );
		var $target = $( $this.data( 'js-relay' ) );
		if ( $target.length ) {
			$target.trigger( 'click' );
		}
	} );

	if ( space.spaceEnabled && space.themeEnabled ) {

		if ( ! $( '.wrap' ).length ) {
			if ( ! $body.hasClass( 'gutenberg-editor-page' ) && ! $body.hasClass( 'block-editor-page' ) ) {
				$( '#wpbody-content' ).wrapInner( '<div class="wrap" />' );
				$( '#screen-meta-links' ).insertBefore( $( '#wpbody-content > .wrap' ) );
			}
		}

	}

	// not.center

	if ( space.spaceEnabled && $body.hasClass( 'space-notification-center' ) && ! space.isMobile ) {

		var $toolbar_item = $( '#wp-admin-bar-space-notification-center' );
		var $submenu = $toolbar_item.find( '.ab-submenu' );
		var notification_count = 0;
		var important_flag = false;
		var alert_classes = '.update-nag, .notice, .notice-success, .updated, .settings-error, .error, .notice-error, .notice-warning, .notice-info';
		var $alerts = $( alert_classes )
			.not( '.inline, .theme-update-message, .hidden, .hide-if-js' )
			.not( '#gadwp-notice, .rs-update-notice-wrap' );
		var greens = [ 'updated', 'notice-success' ];
		var reds = [ 'error', 'notice-error', 'settings-error' ];
		var blues = [ 'update-nag', 'notice', 'notice-info', 'update-nag', 'notice-warning' ];

		$alerts.each( function( i ) {

			var $alert = $( this );
			//var content = $alert.html();
			// content = content.replace( /^\s+|\s+$/g, '' );
			if ( ! $alert.html().replace( /^\s+|\s+$/g, '' ).length ) {
				return true;
			}

			var j;
			var priority = 'neutral';
			for ( j = 0; j < reds.length; j += 1 ) {
				if ( $alert.hasClass( reds[ j ] ) ) {
					if ( ! $alert.hasClass( 'updated' ) ) {
						priority = 'red';
						if ( ! important_flag ) {
							$toolbar_item.addClass( '-important' );
							important_flag = true;
						}
					}
				}
			}

			var $new_item = $( '<li><div class="ab-item ab-empty-item space-notification-center-item--' + priority + '"></div></li>' ).appendTo( $submenu );
			$alert.clone( true, true ).removeClass( alert_classes.replace( /,|\./g, '' ) ).appendTo( $new_item.children( 'div' ) );
			notification_count += 1;

		} );

		$( '.space-notification-count' ).text( notification_count );

		if ( notification_count ) {
			$alerts.remove();
			$toolbar_item.fadeIn();
		}

	}

	//input text

	if ( space.spaceEnabled ) {

		$( '.space-textarea-code' ).on( 'keydown', function( e ) {

			if ( e.keyCode === 9 ) {

				e.preventDefault();
				var $code = $( this );
				var content = $code.val();
				var selection_start = this.selectionStart;
				var selection_end = this.selectionEnd;

				$code.val( content.substring( 0, selection_start ) + '\t' + content.substring( selection_end ) );

				this.selectionStart = selection_start + 1;
				this.selectionEnd = selection_start + 1;

			}

		} );

	}

	
	//role based
	$( '.space-user-role-toggle' ).on( 'change', 'input', function() {
		var $checkbox = $( this );
		var $roles = $checkbox.parent().siblings();
		var state = $checkbox.prop( 'checked' );
		$checkbox.removeClass( 'space-checkbox-is-partially-checked' );
		$roles.find( 'input' ).not( ':disabled' ).prop( 'checked', state );
	} );

	$( '.space-user-role-toggle' ).on( 'click', 'a', function( e ) {
		e.preventDefault();
		$( this ).parents( '.space-user-role-toggle' ).siblings().toggle();
	} );

	// editor
	if ( ! $body.hasClass( 'mobile' ) && $( '#wp-content-editor-container' ).length ) {

		var $editor_toolbars = $( '#wp-content-editor-container #ed_toolbar, #wp-content-editor-container .mce-toolbar-grp' );
		var top_stick_trigger = 0;
		var max_stick_trigger = 0;

		if ( $editor_toolbars.length ) {
			top_stick_trigger = parseInt( $editor_toolbars.offset().top, 10 );
			max_stick_trigger = top_stick_trigger + 100;
		}

		$document.on( 'tinymce-editor-init', function( e, editor ) {
			var $tinymce_toolbar = $( '#wp-content-editor-container .mce-toolbar-grp' );
			if ( $tinymce_toolbar.length ) {
				$editor_toolbars = $editor_toolbars.add( $tinymce_toolbar );
				top_stick_trigger = parseInt( $tinymce_toolbar.offset().top, 10 );
				max_stick_trigger = top_stick_trigger + 100;
				$window.trigger( 'scroll' );
			}
		} );

		//- $window.on( 'space-on-scroll', function() {
		$window.on( 'scroll', function() {

			var scrolltop = $window.scrollTop();

			if ( ! $editor_toolbars.length ) {
				return;
			}

			if ( scrolltop > top_stick_trigger && scrolltop < max_stick_trigger ) {
				$editor_toolbars.addClass( '-fixed' );
				$editor_toolbars.removeClass( '-top' );
			}
			else if ( scrolltop > max_stick_trigger ) {
				$editor_toolbars.removeClass( '-fixed -top' );
			}
			else {
				$editor_toolbars.addClass( '-top' );
				$editor_toolbars.removeClass( '-fixed' );
			}

		} );

	}

	

	

} );
