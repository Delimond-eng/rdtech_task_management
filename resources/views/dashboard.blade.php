@extends('layouts.app')


@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Tableau de bord</h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/">App</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tableau de bord</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Start::row-1 -->
    <div class="row" id="AppDashboard" v-cloak>
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Les activités en cours.
                    </div>
                    <div class="d-flex">
                        <div class="me-2">
                            <input v-model="search" class="form-control form-control-sm border-primary-subtle" type="text" placeholder="Recherche activité. " aria-label=".form-control-sm example">
                        </div>
                        <div class="dropdown"> <a href="javascript:void(0);" class="btn btn-info btn-sm btn-wave waves-effect waves-light" data-bs-toggle="dropdown" aria-expanded="false"> Exporter en<i class="ri-arrow-down-s-line align-middle ms-1 d-inline-block"></i> </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a class="dropdown-item" href="javascript:void(0);">Excel</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);">PDF</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div v-if="isDataLoading" class="d-flex flex-column justify-content-center align-items-center p-5">
                        <span class="spinner-border text-primary"></span>
                        <span class="text-muted mt-1">Chargement...</span>
                    </div>
                    <div class="table-responsive" v-else>
                        <table class="table text-nowrap table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col" class="bg-primary-transparent text-primary">Date</th>
                                    <th scope="col" class="bg-primary-subtle text-primary">Agent</th>
                                    <th scope="col" class="bg-primary-transparent text-primary">Heure début</th>
                                    <th scope="col" class="bg-primary-subtle text-primary">Heure fin</th>
                                    <th scope="col" class="bg-primary-transparent text-primary">photo</th>
                                    <th scope="col" class="bg-primary-subtle text-primary">status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- <tr v-for="(data, index) in filteredProducts" :key="index">
                                    <td :class="{'text-danger':data.stock <= 0}">
                                        <div class="fs-14 d-flex">
                                            <i class="ri-calendar-2-line me-2"></i>
                                            <span>@{{ data.created_at}}</span>
                                        </div>
                                    </td>
                                    <td class="fw-bold" :class="{'text-danger':data.stock <= 0}">
                                        @{{ data.name  }}
                                    </td>
                                    <td :class="{'text-danger':data.stock <= 0}">
                                        <span class="fw-semibold">@{{ data.category.name}} </span>
                                    </td>
                                    <td :class="{'text-danger':data.stock <= 0}">
                                        <span class="fw-semibold">@{{ data.unit_price}}F</span>

                                    </td>
                                    <td :class="{'text-danger':data.stock <= 0}">
                                        <span class="fw-semibold">@{{ data.stock }}</span>
                                    </td>
                                    <td :class="{'text-danger':data.stock <= 0}">
                                        <span class="badge" :class="{'bg-success-transparent':data.stock > 0, 'bg-danger-transparent':data.stock === 0 }">@{{data.stock > 0 ? 'En stock' : 'Sans stock' }}</span>
                                    </td>
                                </tr> -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/main/vue2.js') }}"></script>
<script type="module" src="{{ asset('assets/js/scripts/dashboard.js') }}"></script>
@endsection