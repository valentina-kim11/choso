<!--===Phần Bộ Lọc Chung Bắt Đầu===-->
<form action="">
    <div class="row align-items-center">
        <div class="row mt-2">
            <div class="col-lg-2">
                <div class="tp_form_wrapper">
                    <div class="tp_custom_select">
                        <select class="form-control" name="key">
                            <option selected value="">Chọn trường</option>
                            @foreach ($searchable as $key => $val)
                                <option value="{{ $key }}" @if (request('key') == $key) selected @endif>
                                    {{ $val }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="tp_form_wrapper">
                    <div class="tp_custom_select">
                        <select class="form-control" name="filter">
                            <option selected value="">Bộ lọc</option>
                            @php
                                $filter = [
                                    'contains' => 'Chứa',
                                    'equals' => 'Bằng',
                                    'greaterEquals' => 'Lớn hơn hoặc bằng',
                                    'lesserEquals' => 'Nhỏ hơn hoặc bằng',
                            ]; @endphp
                            @foreach ($filter as $key => $val)
                                <option value="{{ $key }}" @if (request('filter') == $key) selected @endif>
                                    {{ $val }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="tp_form_wrapper tp_pro_search">
                    <input type="text" class="form-control" placeholder="Tìm kiếm..." name="s"
                        value="{{ request('s') }}">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="tp_prosearch_btn">
                    <button type="submit" class="tp_btn">Tìm kiếm</button>
                    <a href="{{ Request::url() }}" class="tp_btn"><i class="fa fa-refresh"></i></a>
                </div>
            </div>
        </div>
    </div>
</form>
<!--===Phần Bộ Lọc Chung Kết Thúc===-->