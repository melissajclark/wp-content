(function( $, window, document, wtaiu ) {
    "use strict";

    $.fn.openToggle = function( settings )
    {
        settings = $.extend( {
            target: this,
            handle: ".open-toggle-handle",
            button: ".open-toggle-button",
            callback: function() {}
        }, settings );

        function _toggle_open( item )
        {
            if ( item.hasClass("open") || ( !item.hasClass("open") && !item.hasClass("closed") ) ) {
                item.removeClass("open").addClass("closed");
            } else {
                item.removeClass("closed").addClass("open");
            }
        }

        function _handle_clicks()
        {
            var item = jQuery(this).closest( settings.target );
            _toggle_open( item );
            settings.callback( item );
        }

        this.delegate( settings.button, "click", _handle_clicks ).delegate( settings.handle, "dblclick", _handle_clicks );
        /*
            @todo update this to check for old jQuery versions.
        */

        return this;
    };

    var wtaiu_sidebar = {

        root: null,
        sidebar: null,
        handle: null,
        closebutton: null,
        panelcontainer: null,
        timer: null,
        data: {},

        init: function()
        {
            this.root           = $("html");
            this.sidebar        = $("#wtaiu");
            this.handle         = $("#wtaiu-handle");
            this.closebutton    = $("#wtaiu-close");
            this.panelcontainer = $("#wtaiu-data");

            if ( wtaiu.data ) {
                this.data = wtaiu.data;
            }

            this.setupContextMenu();
            this.setupSortable();
            this.setupOpenToggle();
            this.setupHelpBoxes();

            this.handle.click( function() {

                if ( wtaiu_sidebar.isOpen() ) {
                    wtaiu_sidebar.close();
                } else {
                    wtaiu_sidebar.open();
                }

                wtaiu_sidebar.saveData();
            } );

            this.closebutton.click( function() {
                wtaiu_sidebar.killSidebar();
            } );

            if ( this.data.open ) {
                this.open();
            } else {
                this.close();
            }

            setTimeout( function() {
                wtaiu_sidebar.addTransitions();
            }, 500 );

        },

        setupSortable: function()
        {
            this.panelcontainer.sortable( {
                handle: ".label",
                helper: "clone",
                items: "> .panel",
                // opacity: .66,
                containment: "parent",
                placeholder: "panel-placeholder",
                update: function() {
                    wtaiu_sidebar.saveData();
                }
            } );
        },

        setupOpenToggle: function()
        {
            this.panelcontainer.openToggle( {
                target: ".panel",
                button: ".open-toggle-button",
                handle: ".panel-header",
                callback: function() {
                    wtaiu_sidebar.saveData();
                }
            } );
        },

        setupHelpBoxes: function()
        {
            var help = $(".panel:has(.help)", this.panelcontainer );
            help.each( function() {
                $( ".label", this ).append("<a class='help-label'>?</a>");
            } );

            $(".help-label", this.panelcontainer ).click( function( e ) {
                e.preventDefault();

                var panel = $( this ).parents(".panel"),
                    help  = $( ".help", this.parentNode.parentNode.parentNode );

                if ( panel.hasClass("closed") ) {
                    panel.removeClass("closed").addClass("open");
                    help.show();
                } else {
                    help.toggle();
                }

                return false;
            } );
        },

        setupContextMenu: function()
        {
            this.panelcontainer.attr( "contextmenu", "wtaiu-context-menu" );

            $("#wtaiu-context-menu .open-all").click( function() {
                wtaiu_sidebar.panelcontainer.find("> .panel").each( function() {
                    $(this).removeClass("closed").addClass("open");
                } );
                wtaiu_sidebar.saveData();
            } );

            $("#wtaiu-context-menu .close-all").click( function() {
                wtaiu_sidebar.panelcontainer.find("> .panel").each( function() {
                    $(this).removeClass("open").addClass("closed");
                } );
                wtaiu_sidebar.saveData();
            } );

        },

        getData: function()
        {
            return this.data;
        },

        saveData: function()
        {
            clearTimeout( this.timer );
            this.timer = setTimeout( this.sendAjax.bind(this), 500 );

            var panel_status = {};
            this.panelcontainer.find(">.panel").each( function() {
                var panel = $(this),
                    id = panel.attr("id"),
                    is_open = panel.hasClass("open");
                panel_status[ id ] = is_open ? 1 : 0;
            } );
            this.data.panels = panel_status;
        },

        sendAjax: function( use_async )
        {
            if ( typeof use_async == "undefined" ) {
                use_async = false;
            }

            var data = {
                action: "wtaiu_save_data",
                open: this.data.open ? 1 : 0,
                panels: this.data.panels
            };

            $.ajax( {
                type: "POST",
                async: use_async,
                cache: false,
                url: wtaiu.ajaxurl,
                data: data,
                dataType: "json",
                success: function() {},
            } );
        },

        open: function()
        {
            this.root.removeClass("wtaiu-closed").addClass("wtaiu-open");
            this.sidebar.addClass("open");
            this.data.open = true;
        },

        close: function()
        {
            this.root.removeClass("wtaiu-open").addClass("wtaiu-closed");
            this.sidebar.removeClass("open");
            this.data.open = false;
        },

        killSidebar: function()
        {
            if ( !confirm( wtaiu.remove_sidebar_alert1 + "\n\n" + wtaiu.remove_sidebar_alert2 ) ){
                return;
            }

            var data = {
                action: "wtaiu_save_close_sidebar",
            };

            $.post(
                wtaiu.ajaxurl,
                data,
                function( /* data, textstatus, jqxhr */ ) {
                    wtaiu_sidebar.close();
                    setTimeout( function() {
                        // Clean up after X button clicked.
                        wtaiu_sidebar.sidebar.remove();
                        wtaiu_sidebar.root.removeClass("transition-padding wtaiu-closed");
                        $("#wpadminbar").removeClass("transition-right");
                        wtaiu_sidebar = null;
                    }, 250 );
                },
                "json"
            );

        },

        isOpen: function()
        {
            return this.sidebar.hasClass("open");
        },

        addTransitions: function()
        {
            this.sidebar.addClass("transition-right");
            this.handle.addClass("transition-all");
            $("#wpadminbar").addClass("transition-right");
            $("html").addClass("transition-padding");
        }

    };

    window.wtaiu_sidebar = wtaiu_sidebar;

    $( function() {
        wtaiu_sidebar.init();
    } );

})( jQuery, window, document, window.wtaiu || {} );
