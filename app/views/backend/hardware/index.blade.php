@extends('backend/layouts/default')

@section('title0')

    @if (Input::get('status'))
        @if (Input::get('status')=='Pending')
            @lang('general.pending')
        @elseif (Input::get('status')=='RTD')
            @lang('general.ready_to_deploy')
        @elseif (Input::get('status')=='Undeployable')
            @lang('general.undeployable')
        @elseif (Input::get('status')=='Deployable')
            @lang('general.deployed')
         @elseif (Input::get('status')=='Requestable')
            @lang('admin/hardware/general.requestable')
        @elseif (Input::get('status')=='Archived')
            @lang('general.archived')
         @elseif (Input::get('status')=='Deleted')
            @lang('general.deleted')
        @endif
    @else
            @lang('general.all')
    @endif

    @lang('general.assets')
@stop

{{-- Page title --}}
@section('title')
    @yield('title0') :: @parent
@stop

{{-- Page content --}}
@section('content')


<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('create/hardware') }}" class="btn btn-success pull-right"><i class="fa fa-plus icon-white"></i> @lang('general.create')</a>
        <h3>@yield('title0')

             @if (Input::has('order_number'))
                  - Order {{{ Input::get('order_number') }}}
             @endif


       </h3>
    </div>
</div>

<div class="row">

 {{ Form::open([
      'method' => 'POST',
      'route' => ['hardware/bulkedit'],
	  'class' => 'form-horizontal' ]) }}

    <table
    name="assets"
    id="table"
    data-url="{{route('api.hardware.list', array(''=>Input::get('serial')))}}"
    data-cookie="true"
    data-click-to-select="true"
    data-cookie-id-table="assetTable">
        <thead>
            <tr>

                <th data-class="hidden-xs" data-switchable="false" data-searchable="false" data-sortable="false" data-field="checkbox"><div class="text-center"><input type="checkbox" id="checkAll" style="padding-left: 0px;"></div></th>
                <th data-sortable="true" data-field="id" data-visible="true">@lang('general.id')</th>
                <th data-sortable="true" data-field="name"  data-visible="true" data-searchable="true" >@lang('admin/hardware/form.name')</th>
                <!--<th data-sortable="true" data-field="asset_tag">@lang('admin/hardware/table.asset_tag')</th>-->
                <th data-sortable="true" data-field="serial" data-visible="true" data-searchable="true" >@lang('admin/hardware/table.serial')</th>
                <th data-sortable="true" data-field="model" data-visible="true" data-searchable="true" >@lang('admin/hardware/form.model')</th>
                <!--<th data-sortable="true" data-field="status" data-visible="true" data-searchable="true" >@lang('admin/hardware/table.status')</th>
                <th data-sortable="true" data-field="location" data-searchable="true">@lang('admin/hardware/table.location')</th>-->
                <th data-sortable="true" data-field="category" data-visible="true" data-searchable="true">@lang('general.category')</th>
                <th data-sortable="true" data-field="department" data-visible="true" data-searchable="true" >@lang('admin/hardware/form.department')</th>
                <th data-sortable="true" data-field="unit"  data-visible="true" data-searchable="true">@lang('admin/hardware/form.unit')</th>
                <th data-sortable="true" data-field="count" data-visible="true" data-searchable="true">@lang('admin/hardware/form.count')</th>
                <th data-sortable="true" data-field="depreciation_status" data-visible="true" data-searchable="true">@lang('admin/hardware/form.depreciation_status')</th>
                <th data-sortable="true" data-field="user_check"  data-visible="true" data-searchable="true">@lang('admin/hardware/form.user_check')</th>
                <th data-sortable="true" data-field="address" data-visible="true" data-searchable="true">@lang('admin/hardware/form.address')</th>

                <th data-sortable="false" data-field="eol"  data-visible="true" data-searchable="true">@lang('general.eol')</th>
                <th data-sortable="true" data-searchable="true"  data-visible="true" data-field="notes">@lang('general.notes')</th>
                <!--<th data-sortable="true" data-searchable="true"  data-field="order_number">@lang('admin/hardware/form.order')</th>
                <th data-sortable="true" data-searchable="true" data-field="last_checkout">@lang('admin/hardware/table.checkout_date')</th>
                <th data-sortable="true" data-field="expected_checkin" data-searchable="true">@lang('admin/hardware/form.expected_checkin')</th>
                <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="change">@lang('admin/hardware/table.change')</th>-->
                <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="actions" >@lang('table.actions')</th>
            </tr>
        </thead>
       <tfoot>
            <tr>
                <td colspan="12">
                    <select name="bulk_actions">
                        <option value="edit">编辑</option>
                        <option value="labels">生成标签</option>
                    </select>
                    <button class="btn btn-default" id="bulkEdit" disabled>编辑所选</button>
                </td>
            </tr>
        </tfoot>
    </table>

 {{ Form::close() }}
</div>


@section('moar_scripts')
<script src="{{ asset('assets/js/bootstrap-table.js') }}"></script>
<script src="{{ asset('assets/js/extensions/cookie/bootstrap-table-cookie.js') }}"></script>
<script src="{{ asset('assets/js/extensions/mobile/bootstrap-table-mobile.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/bootstrap-table-export.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/tableExport.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/jquery.base64.js') }}"></script>
<script type="text/javascript">
    $('#table').bootstrapTable({
        classes: 'table table-responsive table-no-bordered',
        undefinedText: '',
        iconsPrefix: 'fa',
        showRefresh: true,
        search: true,
        pageSize: {{{ Setting::getSettings()->per_page }}},
        pagination: true,
        sidePagination: 'server',
        sortable: true,
        cookie: true,
        mobileResponsive: true,
        showExport: true,
        showColumns: true,
        exportDataType: 'all',
        exportTypes: ['csv', 'txt','json', 'xml'],
        maintainSelected: true,
        paginationFirstText: "@lang('general.first')",
        paginationLastText: "@lang('general.last')",
        paginationPreText: "@lang('general.previous')",
        paginationNextText: "@lang('general.next')",
        pageList: ['10','25','50','100','150','200'],
        icons: {
            paginationSwitchDown: 'fa-caret-square-o-down',
            paginationSwitchUp: 'fa-caret-square-o-up',
            columns: 'fa-columns',
            refresh: 'fa-refresh'
        },

    });
</script>


<script>
    $(function() {
        function checkForChecked() {
            var check_checked = $('input.one_required:checked').length;
            if (check_checked > 0) {
                $('#bulkEdit').removeAttr('disabled');
            }
            else {
                $('#bulkEdit').attr('disabled', 'disabled');
            }
        }
        $('#table').on('change','input.one_required',checkForChecked);
        $("#checkAll").change(function () {
            $("input:checkbox").prop('checked', $(this).prop("checked"));
            checkForChecked();
        });
    });
</script>
@stop

@stop
