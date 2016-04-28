<div show="{ ready }">

    <!-- Display No entries -->
    <div class="uk-width-medium-1-3 uk-viewport-height-1-2 uk-container-center uk-text-center uk-flex uk-flex-middle" if="{ !entries.length && !filter }">
        <div class="uk-animation-fade">
            <p class="uk-text-xlarge"><i class="uk-icon-list"></i></p>
            <hr>
            @lang('No entries'). <a href="@route('/collections/entry/'.$collection['name'])">@lang('Create an entry').</a>
        </div>
    </div>

    <!-- Div Header row -->
    <div class="uk-clearfix uk-margin-top" if="{entries.length }">
        
        <!-- Display buttons at right -->
        <div class="uk-float-right uk-width-1-3 uk-text-right">

            <!-- Delete one or more records -->
            <a class="uk-button uk-button-large uk-button-danger " onclick="{ removeselected }"  if="{ selected.length }"><i class="uk-icon-trash"></i> @lang('Delete') ({ selected.length })</a>

            <!-- Add entry -->
            <a class="uk-button uk-button-large uk-button-primary" href="@route('/collections/entry/'.$collection['name'])">@lang('Add entry')</a>

            <!-- More buttons here -->

        </div>

        <!-- Filter items needs to be disable and replaced with new Filter -->
        <div class="uk-float-left uk-width-2-3">

            &nbsp; &nbsp;
            <i class="uk-icon-search"></i>
            <input class="uk-form-large uk-form-blank" type="text" name="txtfilter" placeholder="@lang('Filter items...')" onchange="{ updatefilter }">

        </div>

    </div>

    <!-- Displays Table - either Sortable or Nonsortable -->
    <div class="uk-margin-top" >
        <table class="uk-table uk-table-striped uk-margin" if="{ entries.length }" id="datatable">
            <!-- Table Header -->
            <thead>
                <tr>
                    <th width="20"><input type="checkbox" data-check="all"></th>
                    <th class="uk-text-orange" each="{field, idx in fields}">
                        { field.label || field.name }
                    </th>
                    <th width="20"></th>
                </tr>
            </thead>
            <!-- Table Body -->
            <tbody name="sortableroot">
                <tr class="uk-visible-hover" each="{entry,idx in entries}" data-id="{ entry._id }">
                    <td><input type="checkbox" data-check data-id="{ entry._id }"></td>
                    <td class="uk-text-truncate" each="{field,idy in parent.fields}" if="{ field.name != '_modified' }">
                        <a class="uk-link-muted" href="@route('/collections/entry/'.$collection['name'])/{ parent.entry._id }">
                            { String(parent.entry[field.name] === undefined ? '': parent.entry[field.name]) }
                        </a>
                    </td>
                    <td>{  App.Utils.dateformat( new Date( 1000 * entry._modified )) }</td>
                    <td>
                        <span class="uk-float-right" data-uk-dropdown="\{mode:'click'\}">

                            <a class="uk-icon-bars"></a>

                            <div class="uk-dropdown uk-dropdown-flip">
                                <ul class="uk-nav uk-nav-dropdown">
                                    <li class="uk-nav-header">@lang('Actions')</li>
                                    <li><a href="@route('/collections/entry/'.$collection['name'])/{ entry._id }">@lang('Edit')</a></li>
                                    <li><a onclick="{ parent.remove }">@lang('Delete')</a></li>
                                </ul>
                            </div>
                        </span>
                    </td>
                </tr>
            </tbody>
            <!-- Table Footer -->
            <tfoot>
                <tr>
                    <td colspan="{ (2+fields.length ) }">
                        <div class="uk-alert uk-text-small uk-margin-remove">
                         <ul class="uk-pagination" id="datapager">
                            <li class="uk-pagination-previous"><a href="#" data-previous="" if="{start > 0}"><< @lang('Previous')</a></li>
                            <li>{ start+1 } @lang('to') { end } @lang('of') { totentries }</li>
                            <li class="uk-pagination-next"><a href="#" data-next="" if="{end < totentries}">@lang('Next') >></a></li>
                         </ul>   
                        </div>
                    </td>
                </tr> 
            </tfoot>
        </table>
    </div>
</div>
     
// Must be inside Div for Riot View
<script type="view/script">

    var $this = this, $root = App.$(this.root);
    this.collection = {{ json_encode($collection) }};  // Collection model with fields definitions etc.
    this.ready      = false;  
    this.loadmore   = false;
    this.entries    = [];
    this.allentries = [];
    this.start      = 0;
    this.totentries = 0;
    this.fieldsidx  = {};
    this.limit      = 10; 
    this.end      = 10; 
    this.fields     = this.collection.fields.filter(function(field){
        $this.fieldsidx[field.name] = field;
        return field.lst;
    });

    this.fields.push({name:'_modified', 'label':'@lang('Modified')'});

    this.sort     = {'_created': -1};
    this.selected = [];

    // Mount
    this.on('mount', function(){

        $root.on('click', '[data-check]', function() {
            if (this.getAttribute('data-check') == 'all') {
                $root.find('[data-check][data-id]').prop('checked', this.checked);
            }
            $this.checkselected();
            $this.update();
        });

        // Snippet 1
        this.sort = {'_order': 1};
        UIkit.sortable(this.sortableroot, {
            animation: false
        });
        // End snippet 1

        var rs = this.load();

        $root.on('click', '[data-previous]', function(e) {
            this.start = this.start - this.limit;
            if(this.start < 0) {this.start = 0};
            this.entries = this.paginate();
            this.checkselected();
            this.update();    
        }.bind(this))

        $root.on('click', '[data-next]', function(e) {
            this.start = this.start + this.limit;
            if(this.end > this.totentries) {this.end = this.totentries};
            this.entries = this.paginate();
            this.checkselected();
            this.update();  
        }.bind(this))
    });

    remove(e, entry, idx) {

        entry = e.item.entry
        idx   = e.item.idx;

        App.ui.confirm("Are you sure?", function() {
            App.callmodule('collections:remove', [this.collection.name, {'_id':entry._id}]).then(function(data) {
                App.ui.notify("Entry removed", "success");
                $this.entries.splice(idx, 1);
                $this.update();
                $this.checkselected(true);
            });
        }.bind(this));
    }

    removeselected() {
        if (this.selected.length) {
            App.ui.confirm("Are you sure?", function() {
                var promises = [];
                this.entries = this.entries.filter(function(entry, yepp){
                    yepp = ($this.selected.indexOf(entry._id) === -1);
                    if (!yepp) {
                        promises.push(App.callmodule('collections:remove', [$this.collection.name, {'_id':entry._id}]));
                    }
                    return yepp;
                });

                Promise.all(promises).then(function(){
                    App.ui.notify("Entries removed", "success");
                });

                this.update();
                this.checkselected(true);

            }.bind(this));
        }
    }

    load() {

        // Snippet 2
        var options = { sort: this.sort };

       // Gets all data
        return App.callmodule('collections:find', [this.collection.name, options]).then(function(data) {

            this.allentries = data.result;
            this.totentries = data.result.length; // Number of entries in total
            this.entries = this.paginate();
            this.ready   = true; // now display

            this.checkselected();
            this.update();

        }.bind(this))
        // End Snippet 2
    }

    updatesort(e, field) {

        field = e.target.getAttribute('data-sort');

        if (!field) {
            return;
        }

        if (!this.sort[field]) {
            this.sort        = {};
            this.sort[field] = 1;
        } else {
            this.sort[field] = this.sort[field] == 1 ? -1:1;
        }

        this.entries = [];

        this.load();
    }

    checkselected(update) {

        var checkboxes = $root.find('[data-check][data-id]'),
            selected   = checkboxes.filter(':checked');

        this.selected = [];

        if (selected.length) {

            selected.each(function(){
                $this.selected.push(App.$(this).attr('data-id'));
            });
        }

        $root.find('[data-check="all"]').prop('checked', checkboxes.length === selected.length);

        if (update) {
            this.update();
        }
    }

    updatefilter() {
        var load = this.filter ? true:false;
        this.filter = null;
        if (this.txtfilter.value) {

            var filter       = this.txtfilter.value,
                criterias    = [],
                allowedtypes = ['text','longtext','boolean','select','html','wysiwyg','markdown'],
                criteria;

            if (App.Utils.str2json('{'+filter+'}')) {

                filter = App.Utils.str2json('{'+filter+'}');

                var key, field;

                for (key in filter) {

                    field = this.fieldsidx[key] || {};

                    if (allowedtypes.indexOf(field.type) !== -1) {

                        criteria = {};
                        criteria[key] = field.type == 'boolean' ? filter[key]: {'$regex':filter[key]};
                        criterias.push(criteria);
                    }
                }

                if (criterias.length) {
                    this.filter = {'$and':criterias};
                }

            } else {

                this.collection.fields.forEach(function(field){

                   if (field.type != 'boolean' && allowedtypes.indexOf(field.type) !== -1) {
                       criteria = {};
                       criteria[field.name] = {'$regex':filter};
                       criterias.push(criteria);
                   }

                });

                if (criterias.length) {
                    this.filter = {'$or':criterias};
                }
            }

        }

        if (this.filter || load) {
            this.entries = [];
            this.load();
        }
    }

    paginate() {
        this.end = this.limit+this.start
        if(this.end > this.totentries) {this.end = this.totentries};
        return this.allentries.slice(this.start, this.end);
    }            

</script>