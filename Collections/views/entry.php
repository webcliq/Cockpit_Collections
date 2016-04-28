<div>
    <ul class="uk-breadcrumb">
        <li><a href="@route('/collections')">@lang('Collections')</a></li>
        <li><a href="@route('/collections/entries/'.$collection['name'])">{{ $collection['name'] }}</a></li>
        <li class="uk-active"><span>@lang('Entry')</span></li>
    </ul>
</div>


<div class="uk-margin-top-large" riot-view>

    <div class="uk-alert" if="{ !fields.length }">
        @lang('No fields defined'). <a href="@route('/collections/collection')/{ collection.name }">@lang('Define collection fields').</a>
    </div>


    <div class="uk-grid">

        <div class="uk-width-medium-3-4">

            <form class="uk-form" if="{ fields.length }" onsubmit="{ submit }" id="cliqform">

                <h3>{ entry._id ? 'Edit':'Add' } @lang('Entry')</h3>

                <br>

                <div class="uk-grid uk-grid-match uk-grid-gutter">

                    <div class="uk-width-medium-{field.width} uk-grid-margin" each="{field,idx in fields}" no-reorder>

                        <div class="uk-panel">

                            <label class="uk-text-bold">
                                { field.label || field.name }
                                <span if="{ field.localize }" class="uk-icon-globe" title="@lang('Localized field')" data-uk-tooltip="\{pos:'right'\}"></span>
                            </label>

                            <div class="uk-margin uk-text-small uk-text-muted">
                                { field.info || ' ' }
                            </div>

                            <div class="uk-margin">
                                <cp-field field="{ field }" bind="entry.{ field.localize && parent.lang ? (field.name+'_'+parent.lang):field.name }" cls="uk-form-large"></cp-field>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="uk-margin-top">
                    <button class="uk-button uk-button-large uk-button-primary uk-margin-right">@lang('Save')</button>
                    <a href="@route('/collections/entries/'.$collection['name'])">
                        <span show="{ !entry._id }">@lang('Cancel')</span>
                        <span show="{ entry._id }">@lang('Close')</span>
                    </a>
                </div>

            </form>

        </div>

        <div class="uk-width-medium-1-4">

            <div class="uk-panel">

                <div class="uk-margin uk-form" if="{ languages.length }">

                    <div class="uk-width-1-1 uk-form-select">

                        <label class="uk-text-small">@lang('Language')</label>
                        <div class="uk-margin-small-top">{ lang || 'Default' }</div>

                        <select bind="lang">
                            <option value="">@lang('Default')</option>
                            <option each="{language,idx in languages}" value="{language}">{language}</option>
                        </select>
                    </div>

                </div>

                <div class="uk-margin">
                    <label class="uk-text-small">@lang('Last Modified')</label>
                    <div class="uk-margin-small-top" if="{entry._id}">{  App.Utils.dateformat( new Date( 1000 * entry._modified )) }</div>
                    <div class="uk-margin-small-top" if="{!entry._id}">@lang('Not saved yet')</div>
                </div>

            </div>
        </div>
    </div>

    <script type="view/script">

        var $this = this;

        this.mixin(RiotBindMixin);

        this.collection   = {{ json_encode($collection) }};
        this.fields       = this.collection.fields;

        this.entry        = {{ json_encode($entry) }};

        this.languages    = App.$data.languages;

        // fill with default values
        this.fields.forEach(function(field){

            // Edit actual value or display Default
            if ($this.entry[field.name] === undefined) {
                $this.entry[field.name] = field.options && field.options.default || null;
            }

            // Password
            if (field.type == 'password') {
                $this.entry[field.name] = '';
            }

        });

        this.on('mount', function() {

            // Cycle through the fields on a Form
            $this.fields.forEach(function(field) {
                // Cycle through the options for a field
                $.each(field.options, function(key, value) {
                    var thisField = $("input[bind='entry."+field.name+"']");
                    switch(key) {

                        // Do nothing cases, because they are already dealt with or they belong to DataTable or DataTree
                        case "default":
                        case "type":
                        case "orderable":
                            return;
                        break;

                        // Named cases here that need special handling
                        case "className": thisField.addClass(field.options.className); break;

                        // Finally a default
                        default: thisField.attr(key, value); break;
                    }
                    
                })
            });     

            // Next references - only if Add
            $(".nextref").each(function(i, val) {
                var fldname = $(this).attr("bind"); // ie: entry.reference
                // Get the latest record and update
            });  

            // Unique entries - Add or Update but not to check self


            // Masks


            // Validations

            // bind global command + save
            Mousetrap.bindGlobal(['command+s', 'ctrl+s'], function(e) {

                if (e.preventDefault) {
                    e.preventDefault();
                } else {
                    e.returnValue = false; // ie
                }
                $this.submit();
                return false;
            });
        });

        submit() {

            App.callmodule('collections:save',[this.collection.name, this.entry]).then(function(data) {

                if (data.result) {

                    App.ui.notify("@lang('Saving successful')", "success");

                    $this.entry = data.result;

                    $this.fields.forEach(function(field){

                        if (field.type == 'password') {
                            $this.entry[field.name] = '';
                        }
                    });

                    $this.update();

                } else {
                    App.ui.notify("@lang('Saving failed')", "danger");
                }
            });
        }

    </script>

</div>
