@inject('userUtil', 'App\Presenters\UserPresenter')
{{ $userUtil->getParentIdsByUrl('/backend',request()) }}
@extends('layouts.backend')

@section('title', '欢迎使用后台管理系统')

@section('header')
    <h1>
        Home
        <small>Moell Blog</small>
    </h1>
@endsection

@section('content')
    <!-- statistics chart built with jQuery Flot -->
    <div class="row-fluid chart">
        <h4>
            Statistics
            <div class="btn-group pull-right">
                <button class="glow left">DAY</button>
                <button class="glow middle active">MONTH</button>
                <button class="glow right">YEAR</button>
            </div>
        </h4>
        <div class="span12">
            <div id="statsChart"></div>
        </div>
    </div>
    <!-- end statistics chart -->

    <!-- UI Elements section -->
    <div class="row-fluid section ui-elements">
        <h4>UI Elements</h4>
        <div class="span5 knobs">
            <div class="knob-wrapper">
                <input type="text" value="50" class="knob" data-thickness=".3" data-inputcolor="#333" data-fgcolor="#30a1ec" data-bgcolor="#d4ecfd" data-width="150" />
                <div class="info">
                    <div class="param">
                        <span class="line blue"></span>
                        Active users
                    </div>
                </div>
            </div>
            <div class="knob-wrapper">
                <input type="text" value="75" class="knob second" data-thickness=".3" data-inputcolor="#333" data-fgcolor="#3d88ba" data-bgcolor="#d4ecfd" data-width="150" />
                <div class="info">
                    <div class="param">
                        <span class="line blue"></span>
                        % disk space usage
                    </div>
                </div>
            </div>
        </div>
        <div class="span6 showcase">
            <div class="ui-sliders">
                <div class="slider slider-sample1 vertical-handler"></div>
                <div class="slider slider-sample2"></div>
                <div class="slider slider-sample3"></div>
            </div>
            <div class="ui-group">
                <a class="btn-flat inverse">Large Button</a>
                <a class="btn-flat gray">Large Button</a>
                <a class="btn-flat default">Large Button</a>
                <a class="btn-flat primary">Large Button</a>
            </div>

            <div class="ui-group">
                <a class="btn-flat icon">
                    <i class="tool"></i> Icon button
                </a>
                <a class="btn-glow small inverse">
                    <i class="shuffle"></i>
                </a>
                <a class="btn-glow small primary">
                    <i class="setting"></i>
                </a>
                <a class="btn-glow small default">
                    <i class="attach"></i>
                </a>
                <div class="ui-select">
                    <select>
                        <option selected="" />Dropdown
                        <option />Custom selects
                        <option />Pure css styles
                    </select>
                </div>

                <div class="btn-group">
                    <button class="glow left">LEFT</button>
                    <button class="glow right">RIGHT</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end UI elements section -->

    <!-- table sample -->
    <!-- the script for the toggle all checkboxes from header is located in js/theme.js -->
    <div class="table-products section">
        <div class="row-fluid head">
            <div class="span12">
                <h4>Products <small>Table sample</small></h4>
            </div>
        </div>

        <div class="row-fluid filter-block">
            <div class="pull-right">
                <div class="ui-select">
                    <select>
                        <option />Filter users
                        <option />Signed last 30 days
                        <option />Active users
                    </select>
                </div>
                <input type="text" class="search" />
                <a class="btn-flat new-product">+ Add product</a>
            </div>
        </div>

        <div class="row-fluid">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th class="span3">
                        <input type="checkbox" />
                        Product
                    </th>
                    <th class="span3">
                        <span class="line"></span>Description
                    </th>
                    <th class="span3">
                        <span class="line"></span>Status
                    </th>
                </tr>
                </thead>
                <tbody>
                <!-- row -->
                <tr class="first">
                    <td>
                        <input type="checkbox" />
                        <div class="img">
                            <img src="{{ asset('bootstrapui/img/table-img.png') }}" />
                        </div>
                        <a href="#">There are many variations </a>
                    </td>
                    <td class="description">
                        if you are going to use a passage of Lorem Ipsum.
                    </td>
                    <td>
                        <span class="label label-success">Active</span>
                        <ul class="actions">
                            <li><i class="table-edit"></i></li>
                            <li><i class="table-settings"></i></li>
                            <li class="last"><i class="table-delete"></i></li>
                        </ul>
                    </td>
                </tr>
                <!-- row -->
                <tr>
                    <td>
                        <input type="checkbox" />
                        <div class="img">
                            <img src="{{ asset('bootstrapui/img/table-img.png') }}" />
                        </div>
                        <a href="#">Internet tend</a>
                    </td>
                    <td class="description">
                        There are many variations of passages.
                    </td>
                    <td>
                        <ul class="actions">
                            <li><i class="table-edit"></i></li>
                            <li><i class="table-settings"></i></li>
                            <li class="last"><i class="table-delete"></i></li>
                        </ul>
                    </td>
                </tr>
                <!-- row -->
                <tr>
                    <td>
                        <input type="checkbox" />
                        <div class="img">
                            <img src="{{ asset('bootstrapui/img/table-img.png') }}" />
                        </div>
                        <a href="#">Many desktop publishing </a>
                    </td>
                    <td class="description">
                        if you are going to use a passage of Lorem Ipsum.
                    </td>
                    <td>
                        <ul class="actions">
                            <li><i class="table-edit"></i></li>
                            <li><i class="table-settings"></i></li>
                            <li class="last"><i class="table-delete"></i></li>
                        </ul>
                    </td>
                </tr>
                <!-- row -->
                <tr>
                    <td>
                        <input type="checkbox" />
                        <div class="img">
                            <img src="{{ asset('bootstrapui/img/table-img.png') }}" />
                        </div>
                        <a href="#">Generate Lorem </a>
                    </td>
                    <td class="description">
                        There are many variations of passages.
                    </td>
                    <td>
                        <span class="label label-info">Standby</span>
                        <ul class="actions">
                            <li><i class="table-edit"></i></li>
                            <li><i class="table-settings"></i></li>
                            <li class="last"><i class="table-delete"></i></li>
                        </ul>
                    </td>
                </tr>
                <!-- row -->
                <tr>
                    <td>
                        <input type="checkbox" />
                        <div class="img">
                            <img src="{{ asset('bootstrapui/img/table-img.png') }}" />
                        </div>
                        <a href="#">Internet tend</a>
                    </td>
                    <td class="description">
                        There are many variations of passages.
                    </td>
                    <td>
                        <ul class="actions">
                            <li><i class="table-edit"></i></li>
                            <li><i class="table-settings"></i></li>
                            <li class="last"><i class="table-delete"></i></li>
                        </ul>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="pagination">
            <ul>
                <li><a href="#">&#8249;</a></li>
                <li><a class="active" href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">&#8250;</a></li>
            </ul>
        </div>
    </div>
@endsection