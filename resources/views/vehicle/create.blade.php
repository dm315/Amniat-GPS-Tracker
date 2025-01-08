@extends('01-layouts.master')

@section('title', 'ایجاد وسیله ‌نقلیه جدید')

@section('content')

    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-12 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                </svg>
                            </a>
                        </li>
                        <li class="breadcrumb-item dana">
                            <a href="{{ route('vehicle.index') }}">
                                وسایل نقلیه
                            </a>
                        </li>
                        <li class="breadcrumb-item dana">ایجاد وسیله‌ نقلیه</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @csrf

    <div class="card">
        <div class="card-body">
            <div class="card-wrapper border rounded-3">
                <form action="{{ route('vehicle.store') }}" method="POST" class="row">
                    @csrf
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="name">نام وسیله نقلیه
                            <sup class="text-danger">*</sup>
                        </label>
                        <input class="form-control" id="name" name="name" value="{{ old('name') }}" type="text"
                               placeholder="پژو 206 سفید">
                        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                    </div>


                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="license_plate">پلاک
                            <sup class="text-danger">*</sup>
                        </label>
                        <input class="form-control" id="license_plate" name="license_plate"
                               value="{{ old('license_plate') }}" type="text"
                               placeholder="پلاک وسیله نقلیه را وارد کنید">
                        <div class="text-muted">لطفاً پلاک خودرو را مطابق با فرمت رو به رو وارد نمایید: <strong
                                class="text-muted fw-bold">22 الف 222 ایران 22</strong></div>
                        <x-input-error :messages="$errors->get('license_plate')" class="mt-2"/>
                    </div>


                    @notRole(['user'])
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="user_id">کاربر
                            <sup class="text-danger">*</sup>
                        </label>
                        <x-partials.alpine.input.select-option name="user_id"
                                                               :options="$users->pluck('name' , 'id')->toArray()"/>
                        <x-input-error :messages="$errors->get('user_id')" class="mt-2"/>
                    </div>
                    @endnotRole

                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="status">وضعیت
                            <sup class="text-danger">*</sup>
                        </label>
                        <select class="form-select" name="status" id="status">
                            <option value="0" @selected(old('status') == 0)>غیر فعال</option>
                            <option value="1" selected @selected(old('status') == 0)>فعال</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2"/>
                    </div>

                    <div class="col-12 mt-2">
                        <button class="btn btn-primary" type="submit">ایــــجاد</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
