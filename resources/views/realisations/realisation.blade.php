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
    <style>
        input[type="checkbox"][disabled] {
            accent-color: green !important;
        }
    </style>

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
              <img src="../../assets/images/loggoh.png" width="50px" alt="logo" />
            </a>
          </div>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-top">  <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown d-none d-lg-block user-dropdown">
                <?php $user = Auth::user(); ?>
              <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <img class="img-xs rounded-circle" src="../../assets/images/{{$user->image_user}}" alt="Profile image"> </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                <div class="dropdown-header text-center">
                  <img class="img-md rounded-circle" src="../../assets/images/{{$user->image_user}}" height="45px" width="45px" alt="Profile image">
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
            @if (Auth::user()->role == 'analyste' || Auth::user()->role == 'developpeur')
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
                    <div class="d-sm-flex justify-content-between align-items-start">
                        <div>
                          <h4 class="card-title card-title-dash"> Espace Taches a effectuer  </h4>
                          <p class="card-subtitle card-subtitle-dash"> ajout des taches par employé </p>
                        </div>
                        <div>
                          <button class="btn btn-primary btn-lg text-white mb-0 me-0" data-bs-toggle="modal" data-bs-target="#importModal" type="button" ><i class="menu-icon mdi mdi-format-list-checkbox "></i>Ajouter une nouvelle tache a effectuer   </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th> id </th>
                            <th>  employe</th>
                            <th>  evolution </th>
                            <th>  nbre taches </th>
                            <th>  fini </th>
                            <th>  reste</th>
                            <th> actions </th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($statistiques as $stat )
                             <tr>
                                <td>{{$stat['id']}} </td>
                                <td> {{$stat['nom_gestionnaire']}} </td>
                                <td> {{$stat['evolution']}} % </td>
                                <td> {{$stat['total']}} </td>
                                <td> {{$stat['faites']}} </td>
                                <td> {{$stat['non_faites']}} </td>
                                <td>
                                    <button class="btn btn-secondary text-white" data-id="{{$stat['id']}}"  onclick="openEditModal(this)" > <i class="fas fa-edit"></i> </button>
                                    <button class="btn btn-success text-white" data-id="{{$stat['id']}}" data-bs-target="#taskModal" data-bs-toggle="modal"   onclick="openDeleteModal(this)" > <i class="fas fa-eye"></i> </button>
                                    <button class="btn btn-danger text-white" data-id="{{$stat['id']}}" onclick="openSuppModal(this)"><i class="fas fa-trash"></i></button>
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
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Attribuer une tache   </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="/add_realisations"  id="monFormulaire">
                        @csrf
                        <div class="mb-3">
                            <label for="centreName" class="form-label"> selectionnez l'employe </label>
                            <select name="nom_gestionnaire" class="form-control" id="">
                                <option> selectionnez un employé  </option>
                                @foreach ($employes as $employ )
                                <option value="{{$employ->name}}"> {{$employ->name}} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="all" id="all">
                            <div class="regroup" id="regroup">
                             <div class="mb-3">
                                <label for="centreName" class="form-label"> nom tache  </label>
                                <select name="nom_tache0" class="form-control" id="">
                                    <option> selectionnez une tache  </option>
                                    @foreach ($taches as $tache )
                                    <option value="{{$tache->nom_tache}}"> {{$tache->nom_tache}} </option>
                                    @endforeach
                                </select>
                             </div>
                             <div class="mb-3">
                                <label for="email" class="form-label">Description de la tache </label>
                                <textarea name="description0" class="form-control" id="description" placeholder="Entrer une description de la tache " rows="8"></textarea>
                             </div>
                             <div class="mb-3">
                                <label class="form-label">Période</label>
                                <div class="d-flex gap-2">
                                    <input type="date" name="date_debut0" class="form-control" placeholder="Date de début">
                                    <input type="date" name="date_fin0" class="form-control" placeholder="Date de fin">
                                </div>
                             </div>
                            </div>
                        </div>
                        <div class="button-container">
                            <button type="submit"  class="button btn btn-success" id="enregistrer"> enregistrer </button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                            <button type="button" class=" btn btn-primary" onclick="addDiv(event)" id="addBouton"> ajouter une tache </button>
                        </div>
                        <input type="hidden" id="numRows" name="numRows" value="1">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-scrollable"> <!-- MODAL COMPACT ET SCROLLABLE -->
            <div class="modal-content">
                <div class="modal-header bg-primary text-white py-2">
                    <h6 class="modal-title" id="taskModalLabel">Tâches liées à la réalisation</h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>

                <div class="modal-body p-2">
                    <ul class="list-group list-group-flush" id="tacheList">
                    </ul>
                </div>

                <div class="modal-footer p-2">
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="SuppModal" tabindex="-1" aria-labelledby="suppModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="SuppModal">Supprimer la tache </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer cette tache ?
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Non</button>
                <form method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
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
        let v = 1;
        let w = 1;
        function addDiv(event){
            event.preventDefault();
            var num = document.getElementById('numRows');
            var form = document.getElementById('monFormulaire');
            var newDiv = document.createElement('div');
            newDiv.setAttribute('class', 'regroup');
            newDiv.innerHTML = `
            <div class="mb-3">
                <label for="centreName" class="form-label"> nom tache  </label>
                <select name="nom_tache${v}" class="form-control" id="">
                    <option> selectionnez une tache  </option>
                    @foreach ($taches as $tache )
                    <option value="{{$tache->nom_tache}}"> {{$tache->nom_tache}} </option>
                    @endforeach
                </select>
             </div>
             <div class="mb-3">
                <label for="description" class="form-label">Description de la tache </label>
                <textarea name="description${v}" class="form-control" id="description" placeholder="Entrer une description de la tache " rows="8"></textarea>
             </div>
             <div class="mb-3">
                <label class="form-label">Période</label>
                <div class="d-flex gap-2">
                    <input type="date" name="date_debut${v}" class="form-control" placeholder="Date de début">
                    <input type="date" name="date_fin${v}" class="form-control" placeholder="Date de fin">
                </div>
             </div>`;

             var enregistrer = document.getElementById('enregistrer');
             enregistrer.parentNode.insertBefore(newDiv, enregistrer);
             w++;
             num.value = w;
             v++;
        }
    </script>

    <script>
        function openDeleteModal(button) {
            const idRealisation = button.getAttribute('data-id');

            fetch(`/view_details/${idRealisation}`)
                .then(response => response.json())
                .then(data => {
                    const list = document.getElementById('tacheList');
                    list.innerHTML = ''; // Vide la liste actuelle

                    if (data.length === 0) {
                        list.innerHTML = '<li class="list-group-item text-center text-muted">Aucune tâche trouvée.</li>';
                    } else {
                        data.forEach(tache => {
                            const li = document.createElement('li');
                            li.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center', 'py-1', 'px-2');

                            const label = document.createElement('span');
                            label.textContent = tache.nom_tache ?? 'Tâche sans nom';

                            const status = document.createElement('span');

                            if (tache.status && tache.status.toLowerCase() === 'fait') {
                                status.innerHTML = `
                                    <input type="checkbox" checked disabled
                                        class="form-check-input"
                                        style="width: 1.2em; height: 1.2em; accent-color: green; cursor: default;">
                                `;
                            } else {
                                status.innerHTML = `
                                    <i class="fas fa-times-circle text-danger"
                                    style="font-size: 1.2em; vertical-align: middle;"></i>
                                `;
                            }

                            li.appendChild(label);
                            li.appendChild(status);
                            list.appendChild(li);
                        });
                    }

                    // Affiche le modal
                    const modalElement = document.getElementById('taskModal');
                    const modalInstance = bootstrap.Modal.getOrCreateInstance(modalElement);
                    modalInstance.show();
                })
                .catch(error => {
                    console.error('Erreur de chargement des tâches:', error);
                });
        }
    </script>

    <script>
        function openSuppModal(button) {
        var id = button.getAttribute('data-id');
        document.getElementById('deleteForm').action = '/delete_realisations/' + id;

        var SuppModal = new bootstrap.Modal(document.getElementById('SuppModal'));
        SuppModal.show();
        }
    </script>

  </body>
</html>
