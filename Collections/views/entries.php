<div>
    <ul class="uk-breadcrumb">
        <li><a href="@route('/collections')">@lang('Collections')</a></li>
        <li class="uk-active" data-uk-dropdown="{mode:'click'}">

            <a><i class="uk-icon-bars"></i> {{ @$collection['label'] ? $collection['label']:$collection['name'] }}</a>

            <div class="uk-dropdown">
                <ul class="uk-nav uk-nav-dropdown">
                    <li class="uk-nav-header">@lang('Actions')</li>
                    <li><a href="@route('/collections/collection/'.$collection['name'])">@lang('Edit')</a></li>
                    <li class="uk-nav-divider"></li>
                    <li class="uk-text-truncate"><a href="@route('/collections/export/'.$collection['name'])" download="{{ $collection['name'] }}.collection.json">@lang('Export entries')</a></li>
                </ul>
            </div>

        </li>
    </ul>
</div>

@if(isset($collection['description']) && $collection['description'])
<div class="uk-text-muted uk-panel-box">
    <i class="uk-icon-info-circle"></i> {{ $collection['description'] }}
</div>
@endif

<div class="uk-margin" riot-view>
    @render('collections:views/partials/entries'.($collection['sortable'] ? '.datatable':'.pageable').'.php', compact('collection'))
</div>
