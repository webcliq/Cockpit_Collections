<div>
    <ul class="uk-breadcrumb">
        <li><a href="@route('/collections')">@lang('Collections')</a></li>
        <li class="uk-active"><span>@lang('Collection')</span></li>
    </ul>
</div>

<div class="uk-margin-large-top" riot-view>

    <form class="uk-form" onsubmit="{ submit }">

        <div class="uk-grid uk-grid-divider">

            <div class="uk-width-medium-1-4">

               <div class="uk-margin">
                   <label class="uk-text-small">@lang('Name')</label>
                   <input class="uk-width-1-1 uk-form-large" type="text" name="name" bind="collection.name" pattern="[a-zA-Z0-9_]+" required>
                   <p class="uk-text-small uk-text-muted" if="{!collection._id}">
                       @lang('Only alpha nummeric value is allowed')
                   </p>
               </div>

               <div class="uk-margin">
                   <label class="uk-text-small">@lang('Label')</label>
                   <input class="uk-width-1-1 uk-form-large" type="text" name="label" bind="collection.label">
               </div>

               <div class="uk-margin">
                   <label class="uk-text-small">@lang('Description')</label>
                   <textarea class="uk-width-1-1 uk-form-large" name="description" bind="collection.description" rows="5"></textarea>
               </div>

               <div class="uk-margin">
                   <label class="uk-text-small">@lang('Options')</label>
                   <div class="uk-width-1-1 uk-form-large" style="height:400px;" name="options" id="jsoneditor" bind="collection.options"></div>
               </div>

                <div class="uk-margin">
                    <field-radio bind="collection.displaytype" cls="uk-form-small uk-width-1-1"></field-radio>
                </div>

                <div class="uk-margin">
                    <field-boolean bind="collection.sortable" title="@lang('Display entries with a Datatable')" cls="uk-form-small uk-button-large uk-width-1-1" label="@lang('Display in Datatable')"></field-boolean>
                </div>

                <div class="uk-margin">
                    <field-boolean bind="collection.in_menu" title="@lang('Show in system menu')" cls="uk-form-small uk-button-large uk-width-1-1" label="@lang('Show in system menu')"></field-boolean>
                </div>

            </div>

            <div class="uk-width-medium-3-4">

                <div class="uk-form-row">

                    <h4>@lang('Fields')</h4>

                    <cp-fieldsmanager bind="collection.fields" listoption="true"></cp-fieldsmanager>


                    <div class="uk-margin-large-top" show="{ collection.fields.length }">

                        <div class="uk-button-group uk-margin-right">
                            <button class="uk-button uk-button-large uk-button-primary">@lang('Save')</button>
                            <a class="uk-button uk-button-large" href="@route('/collections/entries')/{ collection.name }" if="{ collection._id }"><i class="uk-icon-list"></i> @lang('Show entries')</a>
                        </div>

                        <a href="@route('/collections')">
                            <span show="{ !collection._id }">@lang('Cancel')</span>
                            <span show="{ collection._id }">@lang('Close')</span>
                        </a>
                    </div>

                </div>

            </div>

        </div>

    </form>

    <script type="view/script">

        var $this = this, f;
        this.mixin(RiotBindMixin);
        this.collection = {{ json_encode($collection) }};      

        this.on('update', function(){

            // lock name if saved
            if (this.collection._id) {
                this.name.disabled = true;
            }
        });

        this.on('mount', function(){
            
            var options = {
                search:false,
                mode: 'view',
                modes: ['code', 'form', 'text', 'tree', 'view'], // allowed modes
            };
            var container = document.getElementById("jsoneditor");
            var editor = new JSONEditor(container, options, this.collection.options);            

            // bind clobal command + save
            Mousetrap.bindGlobal(['command+s', 'ctrl+s'], function(e) {

                if (e.preventDefault) {
                    e.preventDefault();
                } else {
                    e.returnValue = false; // ie
                }

                this.collection.options = editor.get();
                $this.submit();
                return false;
            });
        });

        submit() {

            var collection = this.collection;

            App.callmodule('collections:saveCollection', [this.collection.name, collection]).then(function(data) {

                if (data.result) {

                    App.ui.notify("@lang('Saving successful')", "success");
                    $this.collection = data.result;
                    $this.update();

                } else {

                    App.ui.notify("@lang('Saving failed')", "danger");
                }
            });
        }

    </script>

</div>
