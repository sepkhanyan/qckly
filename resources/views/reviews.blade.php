@extends('home')
@section('content')
    <div id="page-wrapper">
        <div class="page-header clearfix">
            <div class="page-action">
                <div class="form-inline">
                    <div class="row">
                        @if($selectedRestaurant)
                            @if(count($reviews) > 0)
                                <a class="btn btn-danger " id="delete_review">
                                    <i class="fa fa-trash-o"></i>
                                    Delete
                                </a>
                            @else
                                <i style="font-size: 20px">No Review</i>
                            @endif
                        @endif
                        @if(Auth::user()->admin == 1)
                            <div class="form-group col-md-4">
                                <select name="restaurant_name" id="input-name" class="form-control" tabindex="-1"
                                        title="" onchange="top.location.href = this.options[this.selectedIndex].value">
                                    @if($selectedRestaurant)
                                        <option value>{{$selectedRestaurant->name_en}},{{$selectedRestaurant->city_en}}
                                            ,{{$selectedRestaurant->address_en}}</option>
                                    @else
                                        <option value>Select Restaurant</option>
                                    @endif
                                    @foreach($restaurants as $restaurant)
                                        <option value="{{url('/reviews/' . $restaurant->id)}}">{{$restaurant->name_en}}
                                            ,{{$restaurant->area->area_en}},{{$restaurant->city_en}}
                                            ,{{$restaurant->address_en}}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row content">
            <div class="col-md-12">
                @if(count($reviews)>0)
                    <div class="panel panel-default panel-table">
                        <div class="panel-heading">
                            <h2>Reviews</h2>
                            <div class="pull-right">
                                <button class="btn btn-filter btn-xs">
                                    <i class="fa fa-filter"></i>
                                </button>
                            </div>
                        </div>
                        <div class="panel-body panel-filter">
                            <form role="form" id="filter-form" accept-charset="utf-8" method="GET"
                                  action="{{url('/reviews/' . $id )}}">
                                <div class="filter-bar">
                                    <div class="form-inline">
                                        <div class="row">
                                            <div class="col-md-3 pull-right text-right">
                                                <div class="form-group">
                                                    <input type="text" name="review_search"
                                                           class="form-control input-sm" value=""
                                                           placeholder="Search order id or rating.">&nbsp;&nbsp;&nbsp;
                                                </div>
                                                <a class="btn btn-grey" onclick="filterList();" title=""
                                                   data-original-title="Search">
                                                    <i class="fa fa-search"></i>
                                                </a>
                                            </div>

                                            <div class="col-md-8 pull-left">
                                                <div class="form-group">
                                                    <select name="review_date" class="form-control input-sm">
                                                        <option value="">View all dates</option>
                                                        @foreach ($reviews as $review)
                                                            <option value="{{$review->created_at}}">{{date("j M Y", strtotime($review->created_at))}}</option>
                                                        @endforeach
                                                    </select>&nbsp;
                                                </div>
                                                <a class="btn btn-grey" onclick="filterList();" title=""
                                                   data-original-title="Filter">
                                                    <i class="fa fa-filter"></i>
                                                </a>&nbsp;
                                                <a class="btn btn-grey" href="{{url('/reviews/' . $id)}}" title=""
                                                   data-original-title="Clear">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <form role="form" id="list-form" accept-charset="utf-8" method="POST" action="">
                            <div class="table-responsive">
                                <table class="table table-striped table-border">
                                    <thead>
                                    <tr>
                                        <th class="action">
                                            <input type="checkbox"
                                                   onclick="$('input[name*=\'delete\']').prop('checked', this.checked);">
                                        </th>
                                        <th>Author</th>
                                        <th>Order ID</th>
                                        <th>Rating</th>
                                        <th>Review</th>
                                        <th>Date Added</th>
                                        <th>ID</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($reviews as $review)
                                        <tr>
                                            <td class="action">
                                                <input type="checkbox" value="{{ $review->id }}" name="delete"/>
                                            </td>
                                            <td>{{$review->order->user->username}}</td>
                                            <td>{{$review->order_id}}</td>
                                            <td>
                                                @php($drawn = 5)
                                                @php($average_stars = round($review->rate_value * 2) / 2)
                                                @for($i = 0; $i < floor($average_stars); $i++)
                                                    @php($drawn --)
                                                    <img src="/stars/full.png" width="17px" height="17px">
                                                @endfor
                                                @if($review->rate_value - floor($average_stars) == 0.5)
                                                    @php($drawn --)
                                                    <img src="/stars/half.png" width="17px" height="17px">
                                                @endif
                                                @for($i = $drawn; $i > 0; $i--)
                                                    <img src="/stars/empty.png" width="17px" height="17px">
                                                @endfor
                                            </td>
                                            <td class="rating-inline">{{$review->review_text}}</td>
                                            <td>{{date("j M Y", strtotime($review->created_at))}}</td>
                                            <td>{{$review->id}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>
                        {{ $reviews->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection