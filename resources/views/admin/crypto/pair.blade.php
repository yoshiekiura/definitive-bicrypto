@extends('layouts.app')
@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection
@section('content')
<section id="basic-datatable">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <table class="datatables-basic table">
            <thead>
              <tr>
                <th></th>
                <th></th>
                <th>id</th>
                <th>Coin</th>
                <th>Symbol</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
    <!-- Modal to add new record -->
    <div class="modal modal-slide-in fade" id="addModel">
      <div class="modal-dialog sidebar-sm">
        <livewire:pair-add/>
      </div>
    </div>
    <div class="modal modal-slide-in fade" id="updateModal">
        <div class="modal-dialog sidebar-sm">
          <form class="add-new-record modal-content pt-0" action="{{route('admin.crypto.pair.update')}}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" id="id" name="id">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
            <div class="modal-header mb-1">
              <h5 class="modal-title" id="exampleModalLabel">Edit Coin</h5>
            </div>
            <div class="modal-body flex-grow-1">
              <div class="mb-1">
                <label class="form-label" for="name">{{ __('locale.Name')}}</label>
                <input type="text" class="form-control name" id="name" maxlength="80" name="name" value="{{ old('name') }}" placeholder="{{ __('locale.Name')}}" required>
              </div>
              <div class="mb-1">
                  <label class="form-label" for="symbol">{{ __('locale.Symbol')}}</label>
                  <input type="text" class="form-control symbol" id="symbol" maxlength="30" name="symbol" value="{{old('symbol')}}" placeholder="{{ __('locale.Symbol')}}" required>
                  <small class="form-text"> All Capital Letters </small>
                </div>
              <div class="mb-1">
                <label class="form-label" for="image">{{ __('locale.Image')}}</label>
                <input class="form-control image" name="image" type="file" id="customFileLangHTML" required="" />
              </div>
              <div class="mb-1">
                  <label class="form-label" for="status">{{ __('locale.Status')}} </label>
                  <input class="form-check-input" data-width="100%" type="checkbox" data-bs-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="Enable" data-off="Disable" name="status">
              </div>
              <button type="submit" class="btn btn-primary data-submit me-1">{{ __('locale.Update')}}</button>
              <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
          </form>
        </div>
      </div>
  </section>
  <!--/ Basic table -->

<div id="deleteModal" class="modal fade text-start" tabindex="-1" aria-hidden="true" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('locale.Delete Confirmation')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.crypto.pair.delete') }}" method="POST">
                @csrf
                <input type="hidden" id="idd" name="id">
                <div class="modal-body">
                    <p>{{ __('locale.Are you sure want to delete this coin')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('locale.Close')}}</button>
                    <button type="submit" class="btn btn-danger">{{ __('locale.Delete')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('vendor-script')
  {{-- vendor files --}}
  <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.checkboxes.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/jszip.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/pdfmake.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/vfs_fonts.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.rowGroup.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
@endsection

@push('script')
<script>
    $(function () {
        'use strict';

        var dt_basic_table = $('.datatables-basic'),
            dt_date_table = $('.dt-date'),
            dt_complex_header_table = $('.dt-complex-header'),
            dt_row_grouping_table = $('.dt-row-grouping'),
            dt_multilingual_table = $('.dt-multilingual'),
            assetPath = '../../../app-assets/';

        if ($('body').attr('data-framework') === 'laravel') {
            assetPath = $('body').attr('data-asset-path');
        }

        // DataTable with buttons
        // --------------------------------------------------------------------

        if (dt_basic_table.length) {
            var dt_basic = dt_basic_table.DataTable({
                ajax: assetPath + 'data/coinpair.json',
                columns: [
                    {data: 'responsive_id'},
                    {data: 'id'},
                    {data: 'id'}, // used for sorting so will hide this column
                    {data: 'name'},
                    {data: 'symbol'},
                    {data: 'status'},
                    {data: ''}
                ],
                columnDefs: [{
                        // For Responsive
                        className: 'control',
                        orderable: false,
                        responsivePriority: 2,
                        targets: 0
                    },
                    {
                        // For Checkboxes
                        targets: 1,
                        orderable: false,
                        responsivePriority: 3,
                        render: function (data, type, full, meta) {
                            return (
                                '<div class="form-check"> <input class="form-check-input dt-checkboxes" type="checkbox" value="" id="checkbox' +
                                data +
                                '" /><label class="form-check-label" for="checkbox' +
                                data +
                                '"></label></div>'
                            );
                        },
                        checkboxes: {
                            selectAllRender: '<div class="form-check"> <input class="form-check-input" type="checkbox" value="" id="checkboxSelectAll" /><label class="form-check-label" for="checkboxSelectAll"></label></div>'
                        }
                    },
                    {
                        targets: 2,
                        visible: false
                    },
                    {
                        // Avatar image/badge, Name and symbol
                        targets: 3,
                        responsivePriority: 4,
                        render: function (data, type, full, meta) {
                            var $coin_img = (full['image']).toLowerCase(),
                                $name = full['name'],
                                $symbol = full['symbol'];
                            if ($coin_img) {
                                // For Avatar image
                                var $output =
                                    '<img src="' + assetPath + 'assets/images/cryptoCurrency/' + $coin_img + '" alt="'+$symbol+'" width="32" height="32">';
                            } else {
                                // For Avatar badge
                                var stateNum = full['status'];
                                var states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
                                var $state = states[stateNum],
                                    $name = full['name'],
                                    $initials = $name.match(/\b\w/g) || [];
                                $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
                                $output = '<span class="avatar-content">' + $initials + '</span>';
                            }

                            var colorClass = $coin_img === '' ? ' bg-light-' + $state + ' ' : '';
                            // Creates full output for row
                            var $row_output =
                                '<div class="d-flex justify-content-left align-items-center">' +
                                '<div class="avatar ' +
                                colorClass +
                                ' me-1">' +
                                $output +
                                '</div>' +
                                '<div class="d-flex flex-column">' +
                                '<span class="emp_name text-truncate fw-bold">' +
                                $name +
                                '</span>' +
                                '<small class="emp_post text-truncate text-muted">' +
                                $symbol +
                                '</small>' +
                                '</div>' +
                                '</div>';
                            return $row_output;
                        }
                    },
                    {
                        responsivePriority: 1,
                        targets: 4
                    },
                    {
                        // Label
                        targets: -2,
                        render: function (data, type, full, meta) {
                            var $status_number = full['status'];
                            var $status = {
                                1: {
                                    title: 'Enabled',
                                    class: ' badge-light-success'
                                },
                                0: {
                                    title: 'Disabled',
                                    class: ' badge-light-danger'
                                },
                            };
                            if (typeof $status[$status_number] === 'undefined') {
                                return data;
                            }
                            return (
                                '<span class="badge rounded-pill ' +
                                $status[$status_number].class +
                                '">' +
                                $status[$status_number].title +
                                '</span>'
                            );
                        }
                    },
                    {
                        // Actions
                        targets: -1,
                        title: 'Actions',
                        orderable: false,
                        render: function (data, type, full, meta) {
                            var $id = full['id'];
                            return (
                                '<div class="d-inline-flex">' +
                                '<a class="delete-record" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="'+$id+'">' +
                                feather.icons['trash-2'].toSvg({
                                    class: 'font-small-4 me-50'
                                }) +
                                '</a>' +
                                '<a class="item-edit" data-bs-toggle="modal" data-bs-target="#updateModal" data-id="'+$id+'">' +
                                feather.icons['edit'].toSvg({
                                    class: 'font-small-4'
                                }) +
                                '</a>' +
                                '</div>'
                            );
                        }
                    }
                ],
                order: [
                    [2, 'desc']
                ],
                dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                displayLength: 7,
                lengthMenu: [7, 10, 25, 50, 75, 100],
                buttons: [{
                        extend: 'collection',
                        className: 'btn btn-outline-secondary dropdown-toggle me-2',
                        text: feather.icons['share'].toSvg({
                            class: 'font-small-4 me-50'
                        }) + 'Export',
                        buttons: [{
                                extend: 'print',
                                text: feather.icons['printer'].toSvg({
                                    class: 'font-small-4 me-50'
                                }) + 'Print',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: [2, 3, 4, 5]
                                }
                            },
                            {
                                extend: 'csv',
                                text: feather.icons['file-text'].toSvg({
                                    class: 'font-small-4 me-50'
                                }) + 'Csv',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: [2, 3, 4, 5]
                                }
                            },
                            {
                                extend: 'excel',
                                text: feather.icons['file'].toSvg({
                                    class: 'font-small-4 me-50'
                                }) + 'Excel',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: [2, 3, 4, 5]
                                }
                            },
                            {
                                extend: 'pdf',
                                text: feather.icons['clipboard'].toSvg({
                                    class: 'font-small-4 me-50'
                                }) + 'Pdf',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: [2, 3, 4, 5]
                                }
                            },
                            {
                                extend: 'copy',
                                text: feather.icons['copy'].toSvg({
                                    class: 'font-small-4 me-50'
                                }) + 'Copy',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: [2, 3, 4, 5]
                                }
                            }
                        ],
                        init: function (api, node, config) {
                            $(node).removeClass('btn-secondary');
                            $(node).parent().removeClass('btn-group');
                            setTimeout(function () {
                                $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex');
                            }, 50);
                        }
                    },
                    {
                        text: feather.icons['plus'].toSvg({
                            class: 'me-50 font-small-4'
                        }) + 'Add New Coin',
                        className: 'create-new btn btn-primary',
                        attr: {
                            'data-bs-toggle': 'modal',
                            'data-bs-target': '#addModel'
                        },
                        init: function (api, node, config) {
                            $(node).removeClass('btn-secondary');
                        }
                    }
                ],
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function (row) {
                                var data = row.data();
                                return 'Details of ' + data['name'];
                            }
                        }),
                        type: 'column',
                        renderer: function (api, rowIdx, columns) {
                            var data = $.map(columns, function (col, i) {
                                return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                                    ?
                                    '<tr data-dt-row="' +
                                    col.rowIdx +
                                    '" data-dt-column="' +
                                    col.columnIndex +
                                    '">' +
                                    '<td>' +
                                    col.title +
                                    ':' +
                                    '</td> ' +
                                    '<td>' +
                                    col.data +
                                    '</td>' +
                                    '</tr>' :
                                    '';
                            }).join('');

                            return data ? $('<table class="table"/>').append('<tbody>' + data + '</tbody>') : false;
                        }
                    }
                },
                language: {
                    paginate: {
                        // remove previous & next text from pagination
                        previous: '&nbsp;',
                        next: '&nbsp;'
                    }
                }
            });
            $('div.head-label').html('<h6 class="mb-0">Pair Manager</h6>');
        }

        // Flat Date picker
        if (dt_date_table.length) {
            dt_date_table.flatpickr({
                monthSelectorType: 'static',
                dateFormat: 'm/d/Y'
            });
        }
        // Update Record
        $('.datatables-basic tbody').on('click', '.item-edit', function () {
            $('#id').val($(this).attr('data-id'));
        });
        $('.datatables-basic tbody').on('click', '.delete-record', function () {
            $('#idd').val($(this).attr('data-id'));
        });
    });

</script>
@endpush

