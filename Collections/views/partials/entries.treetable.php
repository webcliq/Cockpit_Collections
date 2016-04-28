<div show="{ ready }">
	<style>
		.item {
		  cursor: pointer;
		}
		.bold {
		  font-weight: bold;
		}
		ul {
		  padding-left: 1em;
		  line-height: 1.5em;
		  list-style-type: dot;
		}
	</style>
    <!-- Displays Table - either Sortable or Nonsortable -->
    <div class="uk-margin-top" >
		<!-- item template -->
		<script type="text/x-template" id="item-template">
		  <li>
			<div
			  :class="{bold: isFolder}"
			  @click="toggle"
			  @dblclick="changeType">
			  {{model.name}}
			  <span v-if="isFolder">[{{open ? '-' : '+'}}]</span>
			</div>
			<ul v-show="open" v-if="isFolder">
			  <item
				class="item"
				v-for="model in model.children"
				:model="model">
			  </item>
			  <li @click="addChild">+</li>
			</ul>
		  </li>
		</script>

		<p>(You can double click on an item to turn it into a folder.)</p>

		<!-- the demo root element -->
		<ul id="demo">
		  <item
			class="item"
			:model="treeData">
		  </item>
		</ul>
    </div>
</div>

// Must be inside Div for Riot View
<script type="view/script">

    var $this = this, $root = App.$(this.root);
    this.collection = {{ json_encode($collection) }};  // Collection model with fields definitions etc.
    this.ready      = false;  
    this.fieldsidx  = {};
    this.fields     = this.collection.fields.filter(function(field){
        $this.fieldsidx[field.name] = field;
        return field.lst;
    });
    this.ready      = true;
    var allfields = this.fields; 
    
    // Gets all data
    var opts = {};
    var options = this.collection.options;
    App.callmodule('collections:find', [this.collection.name, opts]).then(function(data) {

        // When Data loaded, create Data for table
            this.allentries = data.result;
            this.totentries = data.result.length; // Number of entries in total
            // Select fields to be included in data stream. DataTables not good at handling invisible data.
            var thisflds = array_flip(options.fields);
            var dtdata = [];
            // Because we are having to pre-process the data before it can be displayed, this slows down the process
            // OK for resultsets up to, say, 100 records. Beyond that, we need to choose correct data, Server side.
            $.each(data.result, function(i, row) {
                var vals = [];
                $.each(thisflds, function(fld, q) {
                    vals.push(row[fld]);
                });
                dtdata.push(vals);
            });

        // Column definition
            var columndefs = []; var q = 1;
            $.each(options.fields, function(i, fld) {
                if(fld != "_id") {
                    allfields.filter(function(field) {
                        if(field.name == fld) {
                            var col = {
                                name: fld,
                                title: field.label,
                                targets: q,
                                orderable: field.options.orderable,
                                // what else
                            };
                            columndefs.push(col); q++;                            
                        }
                    });
                }
            });

        // Row menu with dropdown configured in Collection options
            var menu = '<div data-uk-dropdown="{mode:\'click\', pos:\'bottom-left\'}" >';
            menu += '<i class="uk-icon-navicon uk-icon-small pointer" ></i>';
            menu += '<div class="uk-dropdown uk-dropdown-small">';
            menu += '<ul class="uk-nav uk-nav-dropdown ">';

            // Menu entries
            $.each(options.menu, function(action, text) {
                menu += '<li><a data-action="'+action+'" href="#" class="menubutton">'+text+'</a></li>';
            });
                        
            menu += '</ul>';
            menu += '</div>';
            menu += '</div>';
            var dtmenu = [{
                data: "_id",
                title: "+",
                defaultContent: menu,
                "orderable": false, filterable: false, targets: -1
            }];

        // Dtable columns
            var dtid = [{
                render: function(data, type, full, meta) {
                    return "<input type='checkbox' id='"+data+"' name='_id\[\]' />";
                },
                "orderable": false, filterable: false, targets: 0
            }];

        // Combine elements into columns
            var dtcols = array_merge(dtid, columndefs, dtmenu);

        // Table layout
            var layout = '<"uk-grid"';
            layout += ' <"dttop uk-width-1-1 uk-flex uk-flex-space-between"';
            layout += ' <"uk-width-3-4 uk-flex-middle"B> <"uk-width-1-4 uk-flex-middle"f> >';
            layout += ' <"dttable uk-width-1-1" t>';
            layout += ' <"dtbottom uk-width-1-1 uk-flex uk-flex-space-between"';
            layout += ' <"uk-width-1-4 uk-flex-middle"l> <"uk-width-1-4 uk-flex-top"i> <"uk-width-2-4 uk-flex-middle"p> >';
            layout += '>';

        // Top Buttons
            var topbuttonarray = array_flip(options.topbuttons);
            var topbuttons = [];
            if(array_key_exists("add", topbuttonarray)) {
                topbuttons.push({
                    text: "@lang('Add')",
                    titleAttr: "@lang('Add a new Entry')",
                    action: function ( e, dt, node, config ) {
                        var url = "@route('/collections/entry/'.$collection['name'])";
                        uLoad(url);
                    },
                    className: "uk-button uk-button-primary mr5"                            
                });
            };
            if(array_key_exists("copy", topbuttonarray)) {
                topbuttons.push({
                    extend: "copyHtml5",
                    text: "@lang('Copy')",
                    titleAttr: "@lang('Copy data to Clipboard')",
                    className: "uk-button uk-button-success mr5"                         
                });
            };
            if(array_key_exists("csv", topbuttonarray)) {
                topbuttons.push({
                    extend: "csvHtml5",
                    text: "@lang('CSV')",
                    titleAttr: "@lang('Export to CSV')",
                    className: "uk-button uk-button-success mr5"                           
                })
            };
            if(array_key_exists("excel", topbuttonarray)) {
                topbuttons.push({
                    extend: "excelHtml5",
                    text: "@lang('Excel')",
                    titleAttr: "@lang('Export to Spreadsheet')",
                    className: "uk-button uk-button-success mr5"                           
                })
            };
            if(array_key_exists("pdf", topbuttonarray)) {
                topbuttons.push({
                    extend: "pdfHtml5",
                    text: "@lang('PDF')",
                    titleAttr: "@lang('Export to a PDF document')",
                    className: "uk-button uk-button-success mr5"                           
                })
            };
            if(array_key_exists("print", topbuttonarray)) {
                topbuttons.push({
                    extend: "print",
                    text: "@lang('Print')",
                    className: "uk-button uk-button-success mr5"                           
                })
            };
            if(array_key_exists("help", topbuttonarray)) {
                topbuttons.push({
                    text: "@lang('Help')",
                    action: function ( e, dt, node, config ) {
                        alert("Help");

                    },
                    className: "uk-button uk-button-success mr5"                           
                })
            };
            if(array_key_exists("reset", topbuttonarray)) {
                topbuttons.push({
                    text: "@lang('Reset')",
                    action: function ( e, dt, node, config ) {
                        reLoad();
                    },
                    className: "uk-button uk-button-success"                           
                })
            };

            // More here

        // Table options
            var dtoptions = {
                ordering: true, order: [[1, "asc"], [2, "asc"]], filtering: true,
                dom: layout,
                buttons: topbuttons,
                select: {
                    style:    'os',
                    selector: 'td:first-child'
                },
                data: dtdata,
                columns: dtcols             
            };
        
        var Dt = $('#datatable').DataTable(dtoptions);
        
        // Table events 
            $(".menubutton").livequery("click", function(e) {
                e.preventDefault();
                var action = $(this).data("action");
                var idx = $(this).closest("tr").children("td:first").children("input:first").attr("id");
                switch(action) {

                    case "edit":
                        var url = "/admin/collections/entry/"+$this.collection.name+"/"+idx;
                        uLoad(url);
                    break;

                    case "delete":
                        App.ui.confirm("Are you sure? ", function() { 
                            App.callmodule('collections:remove', [$this.collection.name, {'_id': idx}]).then(function(data) {
                                App.ui.notify("Entry removed", "success");
                                reLoad();
                            });
                        }.bind(this));
                    break;

                    case "view":

                    break;

                    // More Here
                }
            })

        // Ends
    })
</script>


<?php

// demo data
var data = {
  name: 'My Tree',
  children: [
    { name: 'hello' },
    { name: 'wat' },
    {
      name: 'child folder',
      children: [
        {
          name: 'child folder',
          children: [
            { name: 'hello' },
            { name: 'wat' }
          ]
        },
        { name: 'hello' },
        { name: 'wat' },
        {
          name: 'child folder',
          children: [
            { name: 'hello' },
            { name: 'wat' }
          ]
        }
      ]
    }
  ]
}

// define the item component
Vue.component('item', {
  template: '#item-template',
  props: {
    model: Object
  },
  data: function () {
    return {
      open: false
    }
  },
  computed: {
    isFolder: function () {
      return this.model.children &&
        this.model.children.length
    }
  },
  methods: {
    toggle: function () {
      if (this.isFolder) {
        this.open = !this.open
      }
    },
    changeType: function () {
      if (!this.isFolder) {
        Vue.set(this.model, 'children', [])
        this.addChild()
        this.open = true
      }
    },
    addChild: function () {
      this.model.children.push({
        name: 'new stuff'
      })
    }
  }
})

// boot up the demo
var demo = new Vue({
  el: '#demo',
  data: {
    treeData: data
  }
})
