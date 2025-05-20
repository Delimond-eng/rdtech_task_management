@extends('layouts.app')


@section('content')
<div class="container-fluid" id="AppProduct" v-cloak>

    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Produits</h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/">App</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Produits</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Liste des produits
                    </div>
                    <div class="d-sm-flex">
                        <div class="me-3 mb-3 mb-sm-0">
                            <input v-model="search" class="form-control form-control-sm" type="text" placeholder="Recherche produit " aria-label=".form-control-sm example">
                        </div>

                        <button data-bs-toggle="modal" data-bs-target="#product-modal" class="btn btn-primary btn-sm"> <i class="ri-add-line"></i> Ajouter produit </button>
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
                                    <th scope="col" class="bg-primary-transparent text-primary">Matricule</th>
                                    <th scope="col" class="bg-primary-subtle text-primary">Mot de passe</th>
                                    <th scope="col" class="bg-primary-transparent text-primary">Email</th>
                                    <th scope="col" class="bg-primary-subtle text-primary">Téléphone</th>
                                    <th scope="col" class="bg-primary-transparent text-primary">status</th>
                                    <th scope="col" class="bg-primary-subtle text-primary"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(data, index) in filteredAgents" :key="index">
                                    <td>
                                        <div class="fs-14 d-flex">
                                            <i class="ri-calendar-2-line me-2"></i>
                                            <span>@{{ data.created_at}}</span>
                                        </div>
                                    </td>
                                    <td> 
                                        <div class="d-flex align-items-center fw-semibold"> 
                                            <span class="avatar avatar-sm me-2 avatar-rounded"> 
                                                <img src="assets/images/faces/15.jpg" alt="img"> 
                                            </span>@{{ data.nom }}
                                        </div> 
                                    </td>
                                    <td>
                                        <span class="fw-semibold">@{{ data.matricule}} </span>
                                    </td>
                                    <td>
                                        <span class="fw-semibold">@{{ data.password }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-semibold">@{{ data.email }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-semibold">@{{ data.email }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-success">actif</span>
                                    </td>
                                    <td>
                                        <div class="btn-list">
                                            @if (Auth::user()->role=="admin")
                                            <button title="Editer" data-bs-target="#agent-modal" data-bs-toggle="modal" class="btn btn-sm btn-info btn-icon"><i class="ri-edit-2-fill"></i></button>
                                            <button title="Supprimer" @click.prevent="deleteAgent(data.id)" class="btn btn-sm btn-danger btn-icon contact-delete">
                                                <span v-if="load_id == data.id" class="spinner-border spinner-border-sm" style="height:12px; width:12px"></span><i v-else class="ri-delete-bin-line"></i> </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="product-modal" aria-modal="true" role="dialog">
        <form class="modal-dialog modal-xl" @submit.prevent="submitForm" id="form">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Création nouveau agent</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4">
                    <div v-if="error" class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Erreur !</strong>@{{ error }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="bi bi-x"></i></button>
                    </div>
                    <div v-if="result" class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Succès !</strong>@{{ result }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="bi bi-x"></i></button>
                    </div>

                    <div class="row gx-5">
                        <div class="col-xxl-6 col-xl-12 col-lg-12 col-md-6">
                            <div class="card custom-card shadow-none mb-0 border-0">
                                <div class="card-header mb-3 pb-2">
                                    <h2 class="card-title">Produit infos</h2>
                                </div>
                                <div class="card-body p-0">
                                    <div class="row gy-3">
                                        <div class="col-xl-12"> 
                                            <label for="product-name-add" class="form-label">Libellé <sup class="text-danger">*</sup></label>
                                            <input type="text" name="name" v-model="form.name" class="form-control" id="product-name-add" placeholder="Libellé du produit..."> 
                                        </div>
                                        <div class="col-xl-6"> 
                                            <label for="cat" class="form-label">Catégorie <sup class="text-danger">*</sup></label> 
                                            <select v-model="form.category_id" name="category_id" id="cat" class="form-select">
                                                <option value="" selected hidden>--Sélectionnez une catégorie--</option>
                                                <option :value="cat.id" v-for="(cat, i) in categories" :key="i">@{{ cat.name }}</option>
                                            </select>
                                        </div>
                                        <div class="col-xl-6"> <label for="product-actual-price" class="form-label">Prix unitaire de vente</label> <input type="number" v-model="form.unit_price" name="unit_price" class="form-control" id="product-actual-price" placeholder="0.00F"> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-6 col-xl-12 col-lg-12 col-md-6">
                            <div class="card custom-card shadow-none mb-0 border-0">
                                <div class="card-header mb-3 pb-2">
                                    <h2 class="card-title">Approvisionnement(Optionnel)</h2>
                                </div>
                                <div class="card-body p-0">
                                    <div class="row gy-3">
                                        <div class="col-xl-6"> <label for="product-dealer-price" class="form-label">Prix d'achat unitaire</label> <input type="number" v-model="form.purchase.unit_price" name="unit_price2" class="form-control" id="product-dealer-price" placeholder="0.00F"> </div>
                                        <div class="col-xl-6"> <label for="product-discount" class="form-label">Quantité</label> <input type="number" name="quantity" v-model="form.purchase.quantity" class="form-control" id="product-discount" placeholder="0"> </div>
                                        <div class="col-xl-6"> <label for="product-type" class="form-label">Date(optionnel)</label> <input type="date" name="date" v-model="form.purchase.date" class="form-control" id="product-type"> </div>
                                        <div class="col-xl-6"> <label for="product-type" class="form-label">Fournisseur(optionnel)</label> <input type="text" name="supplier_name" v-model="form.purchase.supplier_name" class="form-control" id="product-type" placeholder="Fournisseur(optionnel)..."> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger-light" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" :disabled="isLoading" class="btn btn-primary"><span v-if="isLoading" class="spinner-border spinner-border-sm me-2"></span>Sauvegarder </button>
                </div>
            </div>
        </form>
    </div>

</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/main/vue2.js') }}"></script>
<script type="module" src="{{ asset('assets/js/scripts/agent.js') }}"></script>
@endsection