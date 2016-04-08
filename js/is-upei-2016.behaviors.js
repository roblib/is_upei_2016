(function ($) {

	//this is a bit of a hack that removes the default selectlist, making the remaing one selected 
	Drupal.behaviors.selectlist_defaults = {
		attach: function (context, settings) {

			$('#islandora-bookmark option[value="default"]', context).once( function() {
				$(this).remove();
			});

			/*********************************
			 *  this could be done in css!!  *
			 *********************************/

			$('.form-item-add-bookmarks select', context).once( function() {
				$(this).hide();
			});

			$('.roblib-bookmark-form option[value="default"]', context).once( function() {
				$(this).remove();
			});

			/*********************************
			 *  this could be done in css!!  *
			 *********************************/
			$('.roblib-bookmark-form .form-type-select').once( function() {
				$(this).hide();
			});
			//$('.roblib-bookmark-form select').once( function() {
				//$(this).hide();
			//});

		}
	};

	/*
	 *attach at pretty selectbox dropdown
	 */
	Drupal.behaviors.nicer_select_box = {
		attach: function (context, settings) {
			//$('.islandora-scholar-citation-select-form select').selectbox("attach");
			$('select').selectbox("attach");
		}
	};

	/*
	 *move the bookmarks block on the scholar page
	 */
	Drupal.behaviors.move_bookmarks = {
		attach: function (context, settings) {

			var target = '.scholar-image';

			$(target, context).once(function() {
				$(this).append($('#block-islandora-bookmark-islandora-bookmark'));
			});

			
			var target = '#block-islandora-bookmark-islandora-bookmark';

			$(target, context).once(function() {
				$(this).insertAfter($('#islandora-scholar-citation-select-form'));
			});
		}
	};
	/*
	 *this opens the islandora metadata fieldset
	 */
	Drupal.behaviors.open_metadata = {
		attach: function (context, settings) {
			$('.islandora-metadata').removeClass('collapsed');

			$('.islandora-metadata').once(function() {

				$(this).removeClass('collapsed');

			});
		}
	};

	/*
	 *this moves the search results behind the page title 
	 */
	Drupal.behaviors.solr_search_move_results = {
		attach: function (context, settings) {

			$('#islandora-solr-result-count', context).once(function() {
				$(this).insertAfter($('.page-islandora-search h1'));
			});
		}
	};



	/*
	 *this moves the search navigation on the citation pages
	 */
	Drupal.behaviors.citation_page_blocks = {
		attach: function (context, settings) {

			$('.block--search-navigation', context).once(function() {
				$(this).insertBefore($('form#islandora-scholar-citation-select-form'));
			});

		}
	};


	/*
	 *adds placeholder text in the search box for the jQuery DataTables
	 */
	Drupal.behaviors.placeholder_text = {
		attach: function (context, settings) {

			var target = ".dataTables_filter input";
			var placeholder_text = "Filter Results:";

			$(target).attr("placeholder", placeholder_text).val("").focus().blur();
		}

	};




	/*
	 *move the solr sort box after the facet block title
	 */

	Drupal.behaviors.equal_height_lp_blocks = {

		attach: function (context, settings) {
			$('.lp-second-row .view-content').matchHeight();
		}

	};
	Drupal.behaviors.move_the_sort = {

		attach: function (context, settings) {
			$('.block--islandora-facets .block__title', context).once(function() {
				$(this).after($('#block-islandora-solr-sort'));	
			});
		}

	};


	Drupal.behaviors.mobile_facets = {

		attach: function (context, settings) {
			$("#block-islandora-solr-basic-facets .block__title").click(function() {

				$("#block-islandora-solr-basic-facets .block__content").toggleClass("show_me", 500);
				$("#block-islandora-solr-sort").toggleClass("show_me", 500);


			} );
		}

	};


})(jQuery);
