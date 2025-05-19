<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> gestion de projet  </title>
    <link rel="stylesheet" href="../../assets/vendors/feather/feather.css">
    <link rel="stylesheet" href="../../assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../../assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../../assets/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../assets/vendors/typicons/typicons.css">
    <link rel="stylesheet" href="../../assets/vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="../../assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="../../assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="shortcut icon" href="../../assets/images/favicon.png" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  </head>
  <body>
    <div class="container-scroller">
      <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
          <div class="me-3">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
              <span class="icon-menu"></span>
            </button>
          </div>
          <div>
            <a class="navbar-brand brand-logo" href="profil">
              <img src="../../assets/images/loggoh.png" width="50px" alt="logo" />
            </a>
            <a class="navbar-brand brand-logo-mini" href="profil">
              <img src="../../assets/images/loggoh.png" alt="logo" />
            </a>
          </div>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-top">  <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown d-none d-lg-block user-dropdown">
                <?php $user =Auth::user(); ?>
              <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <img class="img-xs rounded-circle" src="../../assets/images/{{$user->image_user}}" height="45px" width="45px" alt="Profile image"> </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                <div class="dropdown-header text-center">
                  <img class="img-md rounded-circle" src="../../assets/images/{{$user->image_user}}" alt="Profile image">
                  <p class="mb-1 mt-3 fw-semibold">{{$user->name}}</p>
                  <p class="fw-light text-muted mb-0">{{$user->email}}</p>
                  <p>  @if (isset($project_active)){{$project_active->nom_projet}}@endif </p>
                </div>
                <a class="dropdown-item" href="myProfil"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> Mon profil <span class="badge badge-pill badge-danger">1</span></a>
                <a class="dropdown-item" href="deconnexion"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i> Deconnexion </a>
              </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>
      <div class="container-fluid page-body-wrapper">
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            @if (Auth::user()->role == 'admin')
             <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
                <i class="menu-icon mdi mdi-account-circle-outline"></i>
                <span class="menu-title"> Utilisateurs </span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="form-elements">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"><a class="nav-link" href="myProfil"> Mon profil </a></li>
                  <li class="nav-item"><a class="nav-link" href="utilisateurs"> Employes </a></li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="menu-icon mdi mdi-format-list-checkbox  "></i>
                <span class="menu-title"> Taches </span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="taches"> Ajouter une tache </a></li>
                  <li class="nav-item"> <a class="nav-link" href="realisations"> evolution taches </a></li>
                </ul>
              </div>
            </li>
            @endif
            @if (Auth::user()->role == 'developpeur' || Auth::user()->role == 'analyste')
            <li class="nav-item">
              <a class="nav-link" href="mesTaches">
                <i class="menu-icon mdi mdi-clipboard-text-outline"></i>
                <span class="menu-title"> Mes Taches </span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
                <i class="menu-icon mdi mdi-account-circle-outline"></i>
                <span class="menu-title"> Utilisateurs </span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="form-elements">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"><a class="nav-link" href="myProfil"> Mon profil </a></li>
                </ul>
              </div>
            </li>
            @endif
          </ul>
        </nav>
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    @if (session('taskValidated'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('taskValidated') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                    @endif
                    <div class="d-sm-flex justify-content-between align-items-start">
                        <div>
                          <h4 class="card-title card-title-dash"> Espace Taches </h4>
                          <p class="card-subtitle card-subtitle-dash"> management des Taches </p>
                        </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th> tache </th>
                            <th> description </th>
                            <th> date debut </th>
                            <th> date fin </th>
                            <th> status </th>
                            <th> actions </th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach ($taches as $tach )
                            <tr>
                                <td > {{$tach->nom_tache}} </td>
                                <td> {{$tach->description}}  </td>
                                <td> {{$tach->date_debut}} </td>
                                <td> {{$tach->date_fin}}</td>
                                <td> {{$tach->status}} </td>
                                <td>
                                    <button class="btn btn-primary text-white" data-description="{{$tach->description}}" onclick="openVisibleModal(this)"> <i class="fas fa-eye"></i> </button>
                                    <button class="btn btn-success text-white" data-id="{{$tach->id}}" onclick="openValidModal(this)" ><i class="fas fa-check"></i></button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block"> developée par xxx </span>
            </div>
          </footer>
        </div>
      </div>
    </div>

    <div class="modal fade" id="VisibleModal" tabindex="-1" aria-labelledby="VisibleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="VisibleModalLabel">Voir la description de la tâche</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <p id="descriptionContent">Chargement...</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="validModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel"> Marquer la tache comme faite </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                Êtes-vous sûr d'avoir fini cette tache?
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Non</button>
                <form method="POST" id="deleteForm">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-success">Oui</button>
                </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../../assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="../../assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="../../assets/js/off-canvas.js"></script>
    <script src="../../assets/js/template.js"></script>
    <script src="../../assets/js/settings.js"></script>
    <script src="../../assets/js/hoverable-collapse.js"></script>
    <script src="../../assets/js/todolist.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        function ValidModal(button) {
        var id = button.getAttribute('data-id');
        document.getElementById('deleteForm').action = '/valider_taches/' + id;

        var ValidModal = new bootstrap.Modal(document.getElementById('ValidModal'));
        ValidModal.show();
        }
    </script>

    <script>
        function openValidModal(button) {
        var id = button.getAttribute('data-id');
        document.getElementById('deleteForm').action = '/valider_taches/' + id;

        var validModal = new bootstrap.Modal(document.getElementById('validModal'));
        validModal.show();
        }
    </script>

    <script>
        function openVisibleModal(button) {
            var description = button.getAttribute('data-description');
            document.getElementById('descriptionContent').textContent = description;
            var modal = new bootstrap.Modal(document.getElementById('VisibleModal'));
            modal.show();
        }
    </script>

  </body>
</html>
