<?php
		
	/**
	* jPList Controls Class
	*/
	class jplist_controls{
		
		public $jplist_relative_path;
		
		//controls
		public $reset_btn;
		public $items_per_page;
		public $sort_dd;
		public $title_text_filter;
		public $content_text_filter;
		public $pagination_results_top;
		public $pagination_results_bot;
		public $pagination_top;
		public $pagination_bot;
		public $preloader;
		public $categories_checkbox_filter;
		
		//default panels html
		public $top_panel;
		public $bot_panel;
		public $js_settings;
		public $template;
		
		/**
		* constructor
		*/
		public function jplist_controls($jplist_relative_path){
			
			//init properties
			$this->jplist_relative_path = $jplist_relative_path;

			//init default controls html
			$this->reset_btn = $this->get_reset_btn_html();
			$this->items_per_page = $this->get_items_per_page_html();
			$this->sort_dd = $this->get_sort_dd_html();
			$this->title_text_filter = $this->get_title_text_filter_html();
			$this->content_text_filter = $this->get_post_content_text_filter_html();
			$this->pagination_results_top = $this->get_pagination_results_html(false);
			$this->pagination_results_bot = $this->get_pagination_results_html(true);
			$this->pagination_top = $this->get_pagination_html(false);
			$this->pagination_bot = $this->get_pagination_html(true);
			$this->preloader = $this->get_preloader_html();
			$this->categories_checkbox_filter = $this->jplist_categories_checkbox_filter();
			
			//init default panel html
			$this->top_panel = $this->reset_btn . $this->items_per_page . $this->sort_dd . $this->title_text_filter . $this->content_text_filter . $this->categories_checkbox_filter . $this->pagination_results_top . $this->pagination_top . $this->preloader;
			$this->bot_panel = $this->items_per_page . $this->sort_dd . $this->pagination_results_bot . $this->pagination_bot;
			
			//init default js settings
			$this->js_settings = $this->get_js_settings();
			
			//get handlebars template content
			$this->template = $this->get_template_content();
		}
		
		/**
		* checkbox filter for categories
		*/
		public function jplist_categories_checkbox_filter(){
			$html = "";

			$args = array(
				'type'                     => 'post',
				'child_of'                 => 0,
				'parent'                   => '',
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'hide_empty'               => 1,
				'hierarchical'             => 1,
				'exclude'                  => '',
				'include'                  => '',
				'number'                   => '',
				'taxonomy'                 => 'otmetki',
				'pad_counts'               => false
			);

			$categories = get_categories($args);
			
			$html .= "<!-- checkbox filters -->\r\n";
			$html .= "<div \r\n";
			   $html .= "\tclass='jplist-group'\r\n";
			   $html .= "\tdata-control-type='checkbox-group-filter'\r\n";
			   $html .= "\tdata-control-action='filter'\r\n";
			   $html .= "\tdata-control-name='categories'>\r\n\r\n";
			   
			   foreach ($categories as $category) {
				   $html .= "\t<input \r\n";
					  $html .= "\t\tdata-path='." . $category->slug . "' \r\n";
					  $html .= "\t\tid='jplist-cat-" . $category->slug . "' \r\n";
					  $html .= "\t\ttype='checkbox' \r\n";									
				   $html .= "\t/>\r\n\r\n";
				   
				   $html .= "\t<label for='jplist-cat-" . $category->slug . "'>" . $category->name . "</label>\r\n\r\n";	
				}			   
			   
			$html .= "</div>\r\n\r\n";

			$args = array(
				'type'                     => 'post',
				'child_of'                 => 0,
				'parent'                   => '',
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'hide_empty'               => 1,
				'hierarchical'             => 1,
				'exclude'                  => '',
				'include'                  => '',
				'number'                   => '',
				'taxonomy'                 => 'collekcii',
				'pad_counts'               => false
			);

			$categories = get_categories($args);

			/* TAG:Коллекции */
			$html .= "<!-- checkbox filters -->\r\n";
			$html .= "<select \r\n";
			   $html .= "\tclass='jplist-group ui dropdown'\r\n";
			   $html .= "\tdata-control-type='select'\r\n";
			   $html .= "\tdata-control-action='filter'\r\n";
			   $html .= "\tdata-control-name='collekcii'>\r\n\r\n";

				$html .= "\t<option \r\n";
				$html .= "\t/>\r\n\r\n";

				$html .= "Коллекция</option>";

			   foreach ($categories as $category) {
				   $html .= "\t<option \r\n";
					  $html .= "\t\tdata-path='." . $category->slug . "' \r\n";
					  $html .= "\t\tid='jplist-collekcii-" . $category->slug . "' \r\n";
				   $html .= "\t/>\r\n\r\n";

				   $html .= "$category->name</option>";
				}

			$html .= "</select>\r\n\r\n";

			/* TAG:Уход */
			$html .= "<!-- checkbox filters -->\r\n";
			$html .= "<select \r\n";
			   $html .= "\tclass='jplist-group ui dropdown'\r\n";
			   $html .= "\tdata-control-type='select'\r\n";
			   $html .= "\tdata-control-action='filter'\r\n";
			   $html .= "\tdata-control-name='uhod'>\r\n\r\n";

				$html .= "\t<option \r\n";
				$html .= "\t/>\r\n\r\n";

				$html .= "Уход</option>";

			   foreach ($categories as $category) {
				   $html .= "\t<option \r\n";
					  $html .= "\t\tdata-path='." . $category->slug . "' \r\n";
					  $html .= "\t\tid='jplist-uhod-" . $category->slug . "' \r\n";
				   $html .= "\t/>\r\n\r\n";

				   $html .= "$category->name</option>";
				}

			$html .= "</select>\r\n\r\n";

			/* TAG:Тип кожи */
			$html .= "<!-- checkbox filters -->\r\n";
			$html .= "<select \r\n";
			   $html .= "\tclass='jplist-group ui dropdown'\r\n";
			   $html .= "\tdata-control-type='select'\r\n";
			   $html .= "\tdata-control-action='filter'\r\n";
			   $html .= "\tdata-control-name='tip_kozhi'>\r\n\r\n";

				$html .= "\t<option \r\n";
				$html .= "\t/>\r\n\r\n";

				$html .= "Тип кожи</option>";

			   foreach ($categories as $category) {
				   $html .= "\t<option \r\n";
					  $html .= "\t\tdata-path='." . $category->slug . "' \r\n";
					  $html .= "\t\tid='jplist-tip_kozhi-" . $category->slug . "' \r\n";
				   $html .= "\t/>\r\n\r\n";

				   $html .= "$category->name</option>";
				}

			$html .= "</select>\r\n\r\n";

			/* TAG:Тип средства */
			$html .= "<!-- checkbox filters -->\r\n";
			$html .= "<select \r\n";
			   $html .= "\tclass='jplist-group ui dropdown'\r\n";
			   $html .= "\tdata-control-type='select'\r\n";
			   $html .= "\tdata-control-action='filter'\r\n";
			   $html .= "\tdata-control-name='tip_sredstva'>\r\n\r\n";

				$html .= "\t<option \r\n";
				$html .= "\t/>\r\n\r\n";

				$html .= "Тип средства</option>";

			   foreach ($categories as $category) {
				   $html .= "\t<option \r\n";
					  $html .= "\t\tdata-path='." . $category->slug . "' \r\n";
					  $html .= "\t\tid='jplist-tip_sredstva-" . $category->slug . "' \r\n";
				   $html .= "\t/>\r\n\r\n";

				   $html .= "$category->name</option>";
				}

			$html .= "</select>\r\n\r\n";
			
			return $html;
		}
		
		/**
		* get preloader 
		*/
		public function get_preloader_html(){
			
			$html = "";
			
			$html .= "<!-- preloader for data sources -->\r\n";
			$html .= "<div \r\n";
				$html .= "\tclass='jplist-hide-preloader jplist-preloader' \r\n";
				$html .= "\tdata-control-type='preloader' \r\n";
				$html .= "\tdata-control-name='preloader' \r\n";
				$html .= "\tdata-control-action='preloader'>\r\n";
				$html .= "\t<img src='" . $this->jplist_relative_path . "/content/img/common/ajax-loader-line.gif' alt='Загрузка...' title='Загрузка...' />\r\n";
			$html .= "</div>\r\n\r\n";
			
			return $html;
		}
		
		/**
		* get handlebars template content
		*/
		public function get_template_content(){
			
			$content = "";
			
			$content .= "<!-- handlebars template -->\r\n";
			$content .= "<script id='jplist-template' type='text/x-handlebars-template'>\r\n";
				
				$content .= "\t<!-- loop items -->\r\n";
				$content .= "\t{{#each this}}\r\n\r\n";				
					
					$content .= "\t\t<!-- jplist item --> \r\n";
					$content .= "\t\t<div class='jplist-item' id='jplist-item-{{ID}}' data-type='item'>\r\n";
					
					$content .= "\t\t\t\t<!-- title -->\r\n";	
					$content .= "\t\t\t\t<div class='jplist-title'><p><a href='{{link}}' title='{{post_title}}'>{{post_title}}</a></p></div>\r\n";	
					
					$content .= "\t\t\t\t<div class='jplist-thumb'><p><a href='{{link}}' title='{{post_title}}'>{{{thumb}}}</a></p></div>\r\n";
								
					$content .= "\t\t\t\t<div class='jplist-item-content'>\r\n";
					$content .= "\t\t\t\t\t<p class='jplist-date'>{{date}} {{time}}</p>\r\n";
					//$content .= "\t\t\t\t\t<p class='jplist-date-hidden'>{{hidden_date}}-{{hidden_time}}</p>\r\n";
					$content .= "\t\t\t\t\t<p class='jplist-excerpt'>{{excerpt}}</p>\r\n";
					$content .= "\t\t\t\t\t<p class='jplist-comments'>{{comment_count}} Comment(s)</p>\r\n";
					$content .= "\t\t\t\t\t<p class='jplist-readmore'><a href='{{link}}' title='{{post_title}}'>Read More &#187;</a></p>\r\n";
					$content .= "\t\t\t\t</div>\r\n";
					
					$content .= "\t\t</div>\r\n";
					
				$content .= "\t{{/each}}\r\n";
			$content .= "</script>\r\n";
			
			return $content;
		}
		
		/**
		* get javascript settings
		* @return {string}
		*/
		public function get_js_settings(){
						
			$js = "";
			
			$js .= "jQuery('document').ready(function(){\r\n\r\n";
							
				$js .= "\tvar \$list = jQuery('.jplist .jplist-list')\r\n";
					$js .= "\t\t,template = Handlebars.compile(jQuery('#jplist-template').html());\r\n\r\n";
				
				$js .= "\t//init jplist with php + mysql data source, json and handlebars template\r\n";
				$js .= "\tjQuery('.jplist').jplist({\r\n\r\n";
				
					$js .= "\t\titemsBox: '.jplist-list'\r\n"; 
					$js .= "\t\t,itemPath: '[data-type=\"item\"]'\r\n"; 
					$js .= "\t\t,panelPath: '.jplist-panel'\r\n\r\n";
					
					//$js .= "\t\t,storage: 'localstorage'\r\n"; 
					//$js .= "\t\t,storageName: 'jplist'\r\n\r\n"; 
					
					$js .= "\t\t//data source\r\n";
					$js .= "\t\t,dataSource: {\r\n\r\n";
						
						$js .= "\t\t\ttype: 'server'\r\n";
						$js .= "\t\t\t,server: {\r\n\r\n";
						
							$js .= "\t\t\t\t//ajax settings\r\n";
							$js .= "\t\t\t\tajax:{\r\n";
							  $js .= "\t\t\t\t\turl: '" . admin_url('admin-ajax.php') . "'\r\n"; 
							  $js .= "\t\t\t\t\t,dataType: 'json'\r\n"; 
							  $js .= "\t\t\t\t\t,type: 'POST'\r\n";
							  $js .= "\t\t\t\t\t,data: { action: 'jplist_get_posts' }\r\n";
							$js .= "\t\t\t\t}\r\n";
						$js .= "\t\t\t}\r\n\r\n";
						
						$js .= "\t\t\t//render function for json + templates like handlebars, xml + xslt etc.\r\n";
						$js .= "\t\t\t,render: function(dataItem, statuses){\r\n";
							$js .= "\t\t\t\t\$list.html(template(dataItem.content));\r\n";
						$js .= "\t\t\t}\r\n";
					 $js .= "\t\t}\r\n\r\n";
					 
					 //panel controls
					 $js .= "\t\t,controlTypes:{\r\n";
						
						$js .= "\t\t\t'textbox':{\r\n";
						   $js .= "\t\t\t\tclassName: 'Textbox'\r\n"; 
						   $js .= "\t\t\t\t,options: {\r\n";
							  $js .= "\t\t\t\t\teventName: 'keyup' //'keyup', 'input' or other event\r\n";
							  $js .= "\t\t\t\t\t,ignore: '' \r\n";						
						   $js .= "\t\t\t\t}\r\n";
						$js .= "\t\t\t}\r\n";
					 $js .= "\t\t}\r\n\r\n";

				$js .= "\t});\r\n";
			$js .= "});\r\n";
			
			return $js;
		}
		
		/**
		* get reset button HTML
		* @return {string}
		*/
		public function get_reset_btn_html(){
			
			$html = "";
			$html .= "<!-- reset button -->\r\n";
			$html .= "<button \r\n";
				 $html .= "type='button' \r\n";
				 $html .= "class='jplist-reset-btn' \r\n";
				 $html .= "data-control-type='reset' \r\n";
				 $html .= "data-control-name='reset' \r\n";
				 $html .= "data-control-action='reset'>\r\n";
				 $html .= "\tОчистить  <i class='fa fa-share'></i>\r\n";
			$html .= "</button>\r\n\r\n";
			
			return $html;
		}
		
		/**
		* get items per page dropdown HTML
		* @return {string}
		*/
		public function get_items_per_page_html(){
			
			$html = "";
			$html .= "<!-- items per page dropdown -->\r\n";
			$html .= "<div \r\n";
				$html .= "class='jplist-drop-down' \r\n";
				$html .= "data-control-type='drop-down' \r\n"; 
				$html .= " data-control-name='paging' \r\n"; 
				$html .= "data-control-action='paging'>\r\n";
			 
				$html .= "\t<ul>\r\n";
					$html .= "\t\t<li><span data-number='3'> 3 на страницу </span></li>\r\n";
					$html .= "\t\t<li><span data-number='6' data-default='true'> 6 на страницу </span></li>\r\n";
					$html .= "\t\t<li><span data-number='12'> 12 на страницу </span></li>\r\n";
					$html .= "\t\t<li><span data-number='all'> посмотреть все </span></li>\r\n";
				$html .= "\t</ul>\r\n";
			$html .= "</div>\r\n\r\n";
			
			return $html;
		}
		
		/**
		* get sort dropdown HTML
		* @return {string}
		*/
		public function get_sort_dd_html(){
			
			$html = "";
			$html .= "<!-- sort dropdown -->\r\n";
			$html .= "<div \r\n";
				 $html .= "class='jplist-drop-down' \r\n"; 
				 $html .= "data-control-type='drop-down' \r\n"; 
				 $html .= "data-control-name='sort' \r\n";
				 $html .= "data-control-action='sort' \r\n";
				 $html .= "data-datetime-format='{year}-{month}-{day}-{hour}-{min}-{sec}'>\r\n";
				 
				 $html .= "\t<ul>\r\n";
					$html .= "\t\t<li><span data-path='default'>Сортировать по</span></li>\r\n";
					$html .= "\t\t<li><span data-path='.jplist-title' data-order='asc' data-type='text'>Имени А-Я</span></li>\r\n";
					$html .= "\t\t<li><span data-path='.jplist-title' data-order='desc' data-type='text'>Имени в обратном порядке Я-А</span></li>\r\n";
//					$html .= "\t\t<li><span data-path='.jplist-date' data-order='asc' data-type='datetime'>Post Date asc</span></li>\r\n";
//					$html .= "\t\t<li><span data-path='.jplist-date' data-order='desc' data-type='datetime'>Post Date desc</span></li>\r\n";
//					$html .= "\t\t<li><span data-path='.jplist-comments' data-order='asc' data-type='number'>Comments asc</span></li>\r\n";
//					$html .= "\t\t<li><span data-path='.jplist-comments' data-order='desc' data-type='number'>Comments desc</span></li>\r\n";
				 $html .= "\t</ul>\r\n";
			$html .= "</div>\r\n\r\n";
			
			return $html;
		}
		
		/**
		* get title text filter HTML
		* @return {string}
		*/
		public function get_title_text_filter_html(){
			
			$html = "";
			$html .= "<!-- filter by post title -->\r\n";
			$html .= "<div class='text-filter-box'>\r\n";
			 
			$html .= "\t<!--[if lt IE 10]>\r\n";
			$html .= "\t<div class='jplist-label'>Фильтр по названию:</div>\r\n";
			$html .= "\t<![endif]-->\r\n\r\n";
			 
			$html .= "\t<input \r\n";
				$html .= "\tdata-path='.jplist-title' \r\n";
				$html .= "\ttype='text' \r\n";
				$html .= "\tvalue='' \r\n";
				$html .= "\tplaceholder='Фильтр по названию' \r\n";
				$html .= "\tdata-control-type='textbox' \r\n";
				$html .= "\tdata-control-name='title-filter' \r\n";
				$html .= "\tdata-control-action='filter' \r\n";
				$html .= "\tdata-button='#title-search-button' \r\n";
			$html .= "/>\r\n\r\n";
			
			$html .= "\t<button  \r\n";
				$html .= "\ttype='button' \r\n"; 
				$html .= "\tid='title-search-button'> \r\n";
				$html .= "\t<i class='fa fa-search'></i> \r\n";
			$html .= "\t</button> \r\n\r\n";
			
			$html .= "</div>\r\n\r\n";
			
			return $html;
		}
		
		/**
		* get post content text filter HTML
		* @return {string}
		*/
		public function get_post_content_text_filter_html(){
			
			$html = "";
			$html .= "<!-- filter by post content -->\r\n";
			$html .= "<div class='text-filter-box'>\r\n";
			 
			$html .= "\t<!--[if lt IE 10]>\r\n";
			$html .= "\t<div class='jplist-label'>Фильтр по описанию:</div>\r\n";
			$html .= "\t<![endif]-->\r\n\r\n";
			 
			$html .= "\t<input \r\n";
				$html .= "\tdata-path='.jplist-content' \r\n";
				$html .= "\ttype='text' \r\n";
				$html .= "\tvalue='' \r\n";
				$html .= "\tplaceholder='Фильтр по описанию' \r\n";
				$html .= "\tdata-control-type='textbox' \r\n";
				$html .= "\tdata-control-name='content-filter' \r\n";
				$html .= "\tdata-control-action='filter' \r\n";
				$html .= "\tdata-button='#content-search-button' \r\n";
			$html .= "/>\r\n\r\n";
			
			$html .= "\t<button  \r\n";
				$html .= "\ttype='button' \r\n"; 
				$html .= "\tid='content-search-button'> \r\n";
				$html .= "\t<i class='fa fa-search'></i> \r\n";
			$html .= "\t</button> \r\n\r\n";
			
			$html .= "</div>\r\n\r\n";
			
			return $html;
		}
		
		/**
		* get pagination results HTML
		* @return {string}
		*/
		public function get_pagination_results_html($is_bottom){
			
			$html = "";
			$html .= "<!-- pagination info -->\r\n";
			$html .= "<div \r\n";
				 $html .= "\tclass='jplist-label' \r\n";
				 
				 if($is_bottom){
					$html .= "\tdata-type='{start} - {end} из {all}' \r\n";
				 }
				 else{
					$html .= "\tdata-type='Страница {current} из {pages}' \r\n";
				 }
				 
				 $html .= "\tdata-control-type='pagination-info' \r\n"; 
				 $html .= "\tdata-control-name='paging' \r\n";				
				 $html .= "\tdata-control-action='paging'>\r\n";
			$html .= "</div>\r\n\r\n";
			
			return $html;
		}
		
		/**
		* get pagination HTML
		* @return {string}
		*/
		public function get_pagination_html($is_bottom){
			
			$html = "";
			$html .= "<!-- pagination -->\r\n";
			$html .= "<div \r\n";
				$html .= "\tclass='jplist-pagination' \r\n";
				$html .= "\tdata-control-type='pagination' \r\n";
				$html .= "\tdata-control-name='paging' \r\n";
				$html .= "\t data-mode='google-like' \r\n";
				$html .= "\t data-range='4' \r\n";
				
				if($is_bottom){
					$html .= "\tdata-control-animate-to-top='true' \r\n";
				}
				
				$html .= "\tdata-control-action='paging'>\r\n";				
				
			$html .= "</div>\r\n\r\n";
			
			return $html;
		}
	}
?>