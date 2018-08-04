/**
* v4.X TinyMCE specific functions. (from wordpress 3.9)
*/
(function() {
  tinymce.PluginManager.add('exort_shortcode', function(editor, url) {
    editor.addButton('exort_shortcode_button', {
      type  : 'menubutton',
      title : 'Exort Shortcode',
      text  : '',
      style : 'background-image: url("' + url + '/icon.png' + '"); background-repeat: no-repeat; background-position: 2px 1px; background-size: auto 100%;"',
      icon  : true,
      menu  : [
        { text: 'Layouts',
          menu : [
            { text : 'Row', onclick: function() {editor.insertContent('[row (add_clearfix="yes|no") (children_same_height="yes|no")]...[/row]');} },
            { text : 'One Half', onclick: function() {editor.insertContent('[one_half (offset="{0-6}") ]...[/one_half]');} },
            { text : 'One Third', onclick: function() {editor.insertContent('[one_third (offset="{0-8}") ]...[/one_third]');} },
            { text : 'One Fourth', onclick: function() {editor.insertContent('[one_fourth (offset="{0-9}") ]...[/one_fourth]');} },
            { text : 'Two Third', onclick: function() {editor.insertContent('[two_third (offset="{0-4}") ]...[/two_third]');} },
            { text : 'Three Fourth', onclick: function() {editor.insertContent('[three_fourth (offset="{0-3}") ]...[/three_forth]');} },
            { text : 'Column', onclick: function() {editor.insertContent('[column (lg = "{1-12}") (md = "{1-12}") (sm = "{1-12}") (sms = "{1-12}") (xs = "{1-12}") (lgoff = "{0-12}") (mdoff = "{0-12}") (smoff = "{0-12}") (xsoff = "{0-12}") (lghide = "yes|no") (mdhide = "yes|no") (smhide = "yes|no") (smshide = "yes|no") (xshide = "yes|no") (lgclear = "yes|no") (mdclear = "yes|no") (smclear = "yes|no") (smsclear = "yes|no") (xsclear = "yes|no") ]...[/column]');} },
            { text : 'Container', onclick: function() {editor.insertContent('[container]...[/container]');} },
          ]
        },
        { text: 'Typography',
          menu : [
            { text : 'Divider', onclick: function() {editor.insertContent('[divider]');} },
            { text : 'Icon', onclick: function() {editor.insertContent('[icon class=""]');} },
          ]
        },
        { text: 'Content',
          menu : [
            { text : 'Accordion & Toggles', onclick: function() {editor.insertContent('[toggles toggle_type="toggle, accordion" color="transparent, light, dark" border="" mark="arrow, times" active_tab=""][toggle title=""]...[/toggle][/toggles]');} },
            { text : 'Blog Posts', onclick: function() {editor.insertContent('[blog_posts style="masonry, grid, classic" count="" columns="2, 3, 4" pagination="" ids="" category=""]');} },
            { text : 'Button', onclick: function() {editor.insertContent('[button title="" link="#" style="border, fill" color="light, gray, dark, skin" size="xsm, sm, md, lg" target="_blank"]');} },
            { text : 'Social Button', onclick: function() {editor.insertContent('[social_button style="bg, border, border no-border" icon="btn-icon, btn-md" type="square, round, circle" social="facebook, twitter, instagram, google, pinterest, skype, linkedin, youtube, yahoo, rss, dropbox, soundcloud, vimeo, android" title="" link="#" target="_blank"]');} },
            { text : 'Popup Button', onclick: function() {editor.insertContent('[popup_button icon="" type="lightbox-image, individual-gallery, lightbox-video" attach_image="" attach_images="" video_url=""]...[/popup_button]');} },
            { text : 'Call to Action', onclick: function() {editor.insertContent('[call_to_action layout="boxed, fullwidth" style="bar, centered" theme=" , bg-gray, bg-dark, parallax" img_id="" border="" title_style="style1, style2" title="" sub_title="" button_text="" button_href="" button_target="_blank, _top, _parent"]');} },
            { text : 'Subscribe', onclick: function() {editor.insertContent('[subscribe layout="layout1, layout2" title="" subtitle=""]');} },
            { text : 'Counter', onclick: function() {editor.insertContent('[counter style="style1, style2" label="" number="" icon_class=""]');} },
            { text : 'Counter Timer', onclick: function() {editor.insertContent('[counter_timer size="lg, md, sm" border="" datetime="")]');} },
            { text : 'Icon Box', onclick: function() {editor.insertContent('[icon_box style="style-1, ..., style-8" title="" icon_class=""]...[/icon_box]');} },
            { text : 'Message Box', onclick: function() {editor.insertContent('[alert title="" message="" type="success, info, warning, danger" border="" close=""]');} },
            { text : 'Portfolio', onclick: function() {editor.insertContent('[portfolio style="flat, masonry" hover_style="1, 2, 3, 4" ids="" category="" orderby="date, ID, author, title, modified" order="DESC, ASC" count="" columns="{1-4}" (pagination="yes, no")]');} },
            { text : 'Food Menu', onclick: function() {editor.insertContent('[food_menu left="true, false"][food title="" desc="" price="" img_id=""][/food_menu]');} },
            { text : 'Pricing Table Container', onclick: function() {editor.insertContent('[pricing_table_container style="pricing-table-1, pricing-table-2, pricing-table-3" columns="1, 2, 3, 4, 6"][pricing_table pricing_type="" pricing_desc="" title_icon="" active="true, false" currency_symbol="$" price="" unit_text="Month" btn_title="" btn_url="" btn_target="_blank"][/pricing_table_container]');} },
            { text : 'Progress Bars', onclick: function() {editor.insertContent('[progress_bars style="normal, thin"][progress_bar label="" percent="{0-100}"][/progress_bars]');} },
            { text : 'Slider', onclick: function() {editor.insertContent('[slider columns="{1-5}" nav="true, false" nav_over="true, false" nav_style="{1-4}" pagi="true, false" pagi_over="true, false" pagi_style="{1-3}" ][slider_item img_id=""][/slider]');} },
            { text : 'Tabs', onclick: function() {editor.insertContent('[tabs (style="style-1, ..., style-4, features-1, features-2") active_tab_index="1"][tab title="" icon_class=""]...[/tab][/tabs]');} },
            { text : 'Team', onclick: function() {editor.insertContent('[team style="team-style1, ..., team-style5" count="{2-5}"][team_member name="" job="" photo_id=""][/team]');} },
            { text : 'Testimonials', onclick: function() {editor.insertContent('[testimonials style="testimonial-1, testimonial-2" (column="{1-3}")][testimonial author_name="" author_job="" author_img_id=""]...[/testimonial][/testimonials]');} },
            { text : 'Workflow', onclick: function() {editor.insertContent('[process style="work-flow-1, work-flow-2"][process_item title="" left="" icon_class="" img_id=""][/process_item][/process]');} },
          ]
        },
        { text: 'Widget',
          menu : [
            { text : 'Product Category List', onclick: function() {editor.insertContent('[exort_product_category_list title="" icon_class="ti-menu-alt"]');} },
            { text : 'Product Categories', onclick: function() {editor.insertContent('[exort_product_category_list title="" icon_class="ti-menu-alt"]');} },
            { text : 'Product Thumbs', onclick: function() {editor.insertContent('[exort_product_thumbs title="" best_seller="false" best_seller_count="3" ids="" class=""]');} },
            { text : 'Footer Logo', onclick: function() {editor.insertContent('[exort_footer_logo img=""]');} },
            { text : 'Footer Contact Info', onclick: function() {editor.insertContent('[exort_footer_contact_info img=""]');} },
          ]
        },
      ]
    });
  });

  var exort_file_frame = new Array();
  function exort_media_uploader_popup(editor, template) {

      var frame_key = _.random(0, 999999999999999999);

      if ( exort_file_frame[frame_key] ) {
          exort_file_frame[frame_key].open();
          return;
      }
      
      wp.media.is_shortcode = true;

      exort_file_frame[frame_key] = wp.media.frames.file_frame = wp.media({
          frame:   'post',
          state:   'gallery-library',
          library: { type: 'image' },
          button:  { text: 'Add Images' },
          multiple: true
      });
      
      exort_file_frame[frame_key].on( 'select update insert', function() {
          attachment = exort_file_frame[frame_key].state().get('library').toJSON();
          var ids = "";
          for (var i = 0; i < attachment.length; i++) {
            if (i > 0) {
              ids += ",";
            }
            ids += attachment[i].id;
          }
          template = template.replace("{ids}", ids).replace("{mode}", jQuery(exort_file_frame[frame_key].el).find("select[data-setting='mode']").val());
          var mode = jQuery(exort_file_frame[frame_key].el).find("select[data-setting='mode']").val();
          if (mode.indexOf( "slider" ) !== -1) {
            template = template.replace(' columns="{columns}"', '');
          } else {
            template = template.replace('{columns}', jQuery(exort_file_frame[frame_key].el).find("select[data-setting='columns']").val());
          }
          editor.insertContent(template);
      });
      // Finally, open the modal
      exort_file_frame[frame_key].open();
      jQuery(exort_file_frame[frame_key].el).on("change", "select[data-setting='mode']", function() {
        if ( jQuery(this).val().indexOf("slider") !== -1 ) {
          jQuery(exort_file_frame[frame_key].el).find("select[data-setting='columns']").parent().hide();
        } else {
          jQuery(exort_file_frame[frame_key].el).find("select[data-setting='columns']").parent().show();
        }
      });
  }
})();