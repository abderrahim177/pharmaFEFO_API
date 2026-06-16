<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utilisateurs - PharmaStock</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50/50 text-slate-600 flex h-screen overflow-hidden text-sm antialiased">

<?php
$current_page = basename($_SERVER['SCRIPT_NAME']);
?>

<aside class="w-60 bg-slate-900 text-slate-400 flex flex-col justify-between hidden md:flex border-r border-slate-800 shrink-0">
    <div>
        <div class="flex items-center gap-2.5 px-5 py-4 border-b border-slate-800/60">
            <div class="w-7 h-7 bg-teal-500 rounded-lg flex items-center justify-center text-white shadow-sm">
                <i class="fa-solid fa-prescription-bottle-medical text-xs"></i>
            </div>
            <span class="text-sm font-semibold tracking-tight text-white">PharmaStock</span>
        </div>
        
        <nav class="mt-4 px-3 space-y-0.5">
            <a href="dashboard.php" class="flex items-center justify-between px-3 py-2 rounded-md text-xs transition <?php echo ($current_page == 'dashboard.php') ? 'bg-teal-50/10 text-teal-400 font-medium' : 'hover:bg-slate-800/50 hover:text-slate-200 font-normal'; ?>">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-gears text-xs <?php echo ($current_page == 'dashboard.php') ? '' : 'opacity-70'; ?>"></i> Dashboard
                </div>
            </a>

            <a href="table_users.php" class="flex items-center justify-between px-3 py-2 rounded-md text-xs transition <?php echo ($current_page == 'table_users.php') ? 'bg-teal-50/10 text-teal-400 font-medium' : 'hover:bg-slate-800/50 hover:text-slate-200 font-normal'; ?>">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-users-gear text-xs <?php echo ($current_page == 'table_users.php') ? '' : 'opacity-70'; ?>"></i> Users
                </div>
            </a>

            <a href="Medication.php" class="flex items-center justify-between px-3 py-2 rounded-md text-xs transition <?php echo ($current_page == 'Medication.php') ? 'bg-teal-50/10 text-teal-400 font-medium' : 'hover:bg-slate-800/50 hover:text-slate-200 font-normal'; ?>">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-database text-xs"></i> Medication Management 
                </div>
                <span class="text-[10px] bg-emerald-500/10 text-emerald-400 px-1.5 py-0.5 rounded-full font-medium">Sync</span>
            </a>

            <a href="pertes.php" class="flex items-center justify-between px-3 py-2 rounded-md text-xs transition <?php echo ($current_page == 'pertes.php') ? 'bg-teal-50/10 text-teal-400 font-medium' : 'hover:bg-slate-800/50 hover:text-slate-200 font-normal'; ?>">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-file-invoice-dollar text-xs <?php echo ($current_page == 'pertes.php') ? '' : 'opacity-70'; ?>"></i> Pertes Financières
                </div>
            </a>
        </nav>
    </div>

    <div class="border-t border-slate-800/60 p-3 space-y-2">
        <div class="flex items-center gap-2.5 px-2 py-1.5 rounded-lg bg-slate-950/40">
            <div class="w-7 h-7 rounded-md bg-teal-600 flex items-center justify-center text-[11px] font-bold text-white shadow-sm">A</div>
            <div class="leading-tight">
                <p class="text-xs font-medium text-slate-200">Admin</p>
                <p class="text-[10px] text-slate-500">Principal</p>
            </div>
        </div>
        <a href="../logout.php" class="flex items-center gap-2.5 px-3 py-1.5 text-xs font-medium text-rose-400/80 hover:text-rose-400 hover:bg-rose-500/5 rounded-md transition w-full">
            <i class="fa-solid fa-arrow-right-from-bracket text-[11px]"></i> Déconnexion
        </a>
    </div>
</aside>

<main class="flex-1 flex flex-col overflow-y-auto">
    <header class="bg-white border-b border-slate-100 h-14 flex items-center justify-between px-6 shrink-0 shadow-xs">
        <h1 class="text-xs font-semibold uppercase tracking-wider text-slate-700">Console d'Administration</h1>
        <div class="flex items-center gap-2 text-[10px] font-medium text-slate-400 uppercase tracking-wider bg-slate-50 px-2.5 py-1 rounded-full border border-slate-100">
            <span class="h-1.5 w-1.5 bg-emerald-500 rounded-full animate-pulse"></span> Claude Bernard connecté
        </div>
    </header>

    <div class="p-6 space-y-5 max-w-6xl w-full mx-auto">
        
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-white p-5 rounded-xl border border-slate-100 shadow-xs">
            <div>
                <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                    <i class="fa-solid fa-user-shield text-teal-500 text-xs"></i> Gestion des Collaborateurs
                </h2>
                <p class="text-[11px] text-slate-400 mt-0.5">Administrez les accès, rôles et statuts de sécurité des utilisateurs de la plateforme.</p>
            </div>
            <button id="btnOpenAddModal" class="bg-slate-900 hover:bg-slate-800 text-white font-medium py-1.5 px-3 rounded-md text-[11px] flex items-center gap-1.5 transition shadow-xs cursor-pointer">
                <i class="fa-solid fa-user-plus text-[10px] opacity-80"></i> Ajouter un utilisateur
            </button>
        </div>

        <div class="bg-white rounded-xl border border-slate-100 shadow-xs overflow-hidden">
            
            <div class="p-3.5 border-b border-slate-100 bg-slate-50/40 flex items-center justify-between gap-4">
                <div class="relative w-full max-w-xs">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400 text-[11px]"></i>
                    <input type="text" placeholder="Rechercher un membre..." class="w-full pl-8 pr-3 py-1.5 border border-slate-200 rounded-md focus:outline-hidden focus:border-teal-500 focus:bg-white text-xs bg-white transition shadow-2xs">
                </div>
                <span class="text-[10px] text-slate-500 font-semibold bg-slate-200/60 px-2 py-0.5 rounded">Membres</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/70 text-[10px] font-bold uppercase tracking-wider text-slate-400 border-b border-slate-100">
                            <th class="py-2.5 px-4 w-12 text-center">ID</th>
                            <th class="py-2.5 px-4">Collaborateur</th>
                            <th class="py-2.5 px-4">Email</th>
                            <th class="py-2.5 px-4">Rôle</th>
                            <th class="py-2.5 px-4">Date Création</th>
                            <th class="py-2.5 px-4">Statut</th>
                            <th class="py-2.5 px-4 text-right w-20">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-slate-600">
                        <?php if (!empty($users)): ?>
                            <?php foreach ($users as $user): ?>
                                <?php
                                $roleClasses = [
                                    'Administrateur' => 'bg-teal-50 text-teal-700 border-teal-100/40',
                                    'Pharmacien'     => 'bg-emerald-50 text-emerald-700 border-emerald-100/40',
                                    'Preparateur'    => 'bg-amber-50 text-amber-700 border-amber-100/40',
                                    'Préparateur'    => 'bg-amber-50 text-amber-700 border-amber-100/40'
                                ];

                                $currentRole = $user['role'];
                                $badgeClass = $roleClasses[$currentRole] ?? 'bg-slate-50 text-slate-700 border-slate-100';
                                ?>
                                <tr class="hover:bg-slate-50/40 transition">
                                    <td class="py-3 px-4 text-center font-mono text-[11px] text-slate-400 target-id"><?php echo htmlspecialchars($user['id']); ?></td>
                                    <td class="py-3 px-4 font-medium text-slate-800 target-name"><?php echo htmlspecialchars($user['name']); ?></td>
                                    <td class="py-3 px-4 text-slate-500 font-normal target-email"><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td class="py-3 px-4">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold border target-role <?= $badgeClass ?>" data-role="<?php echo htmlspecialchars($user['role']); ?>">
                                            <?php echo htmlspecialchars($user['role']); ?>
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-slate-400 text-[11px]"><?php echo htmlspecialchars($user['created_at']); ?></td>
                                    <td class="py-3 px-4">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] bg-emerald-50 text-emerald-700 font-semibold border border-emerald-100/20 target-status" data-status="<?php echo htmlspecialchars($user['status']); ?>">
                                            <span class="w-1 h-1 bg-emerald-500 rounded-full"></span> <?php echo htmlspecialchars($user['status']); ?>
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <div class="flex items-center justify-end gap-1">
                                            <button title="Modifier" class="btnEditUser p-1 text-slate-400 hover:text-teal-600 hover:bg-slate-50 rounded transition cursor-pointer">
                                                <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                                            </button>
                                            <button title="Supprimer" class="btnDeleteUser p-1 text-slate-400 hover:text-rose-600 hover:bg-slate-50 rounded transition cursor-pointer" 
                                                    data-id="<?php echo htmlspecialchars($user['id']); ?>" 
                                                    data-name="<?php echo htmlspecialchars($user['name']); ?>">
                                                <i class="fa-solid fa-trash-can text-[11px]"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="py-8 text-center text-slate-400 italic bg-slate-50/10">
                                    <i class="fa-solid fa-users-slash text-slate-300 block text-lg mb-1.5"></i>
                                    Aucun utilisateur trouvé.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="p-3.5 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400 bg-slate-50/30">
                <span>Affichage des utilisateurs</span>
                <div class="flex gap-1">
                    <button class="px-2.5 py-1 border border-slate-200 rounded-md hover:bg-white text-slate-500 transition cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed text-[11px]" disabled>Précédent</button>
                    <button class="px-2.5 py-1 border border-slate-200 rounded-md hover:bg-white text-slate-500 transition cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed text-[11px]" disabled>Suivant</button>
                </div>
            </div>

        </div>
    </div>
</main>

<div id="modalAddUser" class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center z-50 hidden transition-all duration-200 opacity-0">
    <div class="bg-white rounded-xl border border-slate-100 shadow-xl w-full max-w-md p-5 space-y-4 relative transform scale-95 transition-all duration-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                <i class="fa-solid fa-user-plus text-teal-500"></i> Nouveau Collaborateur
            </h3>
            <button class="btnCloseModal text-slate-400 hover:text-slate-600 p-1 rounded-md transition cursor-pointer">
                <i class="fa-solid fa-xmark text-xs"></i>
            </button>
        </div>
        <form id="formAddUser" action="/PHARMAFEFO_API/src/controller/web/UserController.php" method="POST" class="space-y-3.5">
            <div>
                <label class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Nom Complet</label>
                <input type="text" name="name" required placeholder="Ex: Amine Benjelloun" class="w-full px-3 py-1.5 border border-slate-200 rounded-md focus:outline-hidden focus:border-teal-500 text-xs bg-white transition shadow-2xs">
            </div>
            <div>
                <label class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Adresse Email</label>
                <input type="email" name="email" required placeholder="nom@clinique.ma" class="w-full px-3 py-1.5 border border-slate-200 rounded-md focus:outline-hidden focus:border-teal-500 text-xs bg-white transition shadow-2xs">
            </div>
            <div>
                <label class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Mot de passe</label>
                <input type="password" name="password" required placeholder="••••••••" class="w-full px-3 py-1.5 border border-slate-200 rounded-md focus:outline-hidden focus:border-teal-500 text-xs bg-white transition shadow-2xs">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Rôle</label>
                    <select name="role" class="w-full px-2 py-1.5 border border-slate-200 rounded-md focus:outline-hidden focus:border-teal-500 text-xs bg-white transition shadow-2xs">
                        <option value="Preparateur">Préparateur</option>
                        <option value="Pharmacien">Pharmacien</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Statut</label>
                    <select name="status" class="w-full px-2 py-1.5 border border-slate-200 rounded-md focus:outline-hidden focus:border-teal-500 text-xs bg-white transition shadow-2xs">
                        <option value="Actif">Actif</option>
                        <option value="Inactif">Inactif</option>
                    </select>
                </div>
            </div>
            <div class="flex items-center justify-end gap-1.5 border-t border-slate-100 pt-3 mt-4">
                <button type="button" class="btnCloseModal border border-slate-200 text-slate-600 text-[11px] font-medium py-1.5 px-3 rounded-md hover:bg-slate-50 transition cursor-pointer">
                    Annuler
                </button>
                <button name='Enregistrer' type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-medium py-1.5 px-3 rounded-md text-[11px] transition shadow-xs cursor-pointer">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

<div id="modalEditUser" class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center z-50 hidden transition-all duration-200 opacity-0">
    <div class="bg-white rounded-xl border border-slate-100 shadow-xl w-full max-w-md p-5 space-y-4 relative transform scale-95 transition-all duration-200">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                <i class="fa-solid fa-pen-to-square text-teal-500"></i> Modifier le Profil
            </h3>
            <button class="btnCloseModal text-slate-400 hover:text-slate-600 p-1 rounded-md transition cursor-pointer">
                <i class="fa-solid fa-xmark text-xs"></i>
            </button>
        </div>
        <form action="/Pharmafefo-/src/controller/UserController.php" method="POST" class="space-y-3.5">
            <input type="hidden" id="edit_user_id" name="id">
            <div>
                <label class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Nom Complet</label>
                <input type="text" id="edit_name" name="name_update" required class="w-full px-3 py-1.5 border border-slate-200 rounded-md focus:outline-hidden focus:border-teal-500 text-xs bg-white transition shadow-2xs">
            </div>
            <div>
                <label class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Adresse Email</label>
                <input type="email" id="edit_email" name="email_update" required class="w-full px-3 py-1.5 border border-slate-200 rounded-md focus:outline-hidden focus:border-teal-500 text-xs bg-white transition shadow-2xs">
            </div>
            <div>
                <label class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Nouveau mot de passe <span class="text-slate-400 font-normal lowercase">(optionnel)</span></label>
                <input type="password" name="password" placeholder="Laisser vide si inchangé" class="w-full px-3 py-1.5 border border-slate-200 rounded-md focus:outline-hidden focus:border-teal-500 text-xs bg-white transition shadow-2xs">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Rôle</label>
                    <select id="edit_role" name="role_update" class="w-full px-2 py-1.5 border border-slate-200 rounded-md focus:outline-hidden focus:border-teal-500 text-xs bg-white transition shadow-2xs">
                        <option value="Preparateur">Préparateur</option>
                        <option value="Pharmacien">Pharmacien</option>
                        <option value="Administrateur">Administrateur</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Statut</label>
                    <select id="edit_status" name="status_update" class="w-full px-2 py-1.5 border border-slate-200 rounded-md focus:outline-hidden focus:border-teal-500 text-xs bg-white transition shadow-2xs">
                        <option value="Actif">Actif</option>
                        <option value="Inactif">Inactif</option>
                    </select>
                </div>
            </div>
            <div class="flex items-center justify-end gap-1.5 border-t border-slate-100 pt-3 mt-4">
                <button type="button" class="btnCloseModal border border-slate-200 text-slate-600 text-[11px] font-medium py-1.5 px-3 rounded-md hover:bg-slate-50 transition cursor-pointer">
                    Annuler
                </button>
                <button type="submit" name="Modifier" class="bg-teal-600 hover:bg-teal-700 text-white font-medium py-1.5 px-3 rounded-md text-[11px] transition shadow-xs cursor-pointer">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>

<div id="modalDeleteUser" class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center z-50 hidden transition-all duration-200 opacity-0">
    <div class="bg-white rounded-xl border border-slate-100 shadow-xl w-full max-w-sm p-5 space-y-3.5 relative transform scale-95 transition-all duration-200">
        <div class="flex items-start gap-3">
            <div class="w-9 h-9 bg-rose-50 text-rose-600 rounded-full flex items-center justify-center shrink-0 border border-rose-100/50">
                <i class="fa-solid fa-triangle-exclamation text-xs"></i>
            </div>
            <div class="space-y-0.5">
                <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Supprimer le collaborateur</h3>
                <p class="text-[11px] text-slate-400 leading-relaxed">
                    Êtes-vous sûr de vouloir supprimer <span id="delete_user_name" class="font-semibold text-slate-700"></span> ? Cette action est irréversible.
                </p>
            </div>
        </div>
        <form action="/Pharmafefo-/src/controller/UserController.php" method="POST">
            <input type="hidden" id="delete_user_id" name="id">
            <div class="flex items-center justify-end gap-1.5 border-t border-slate-100 pt-3 mt-3">
                <button type="button" class="btnCloseModal border border-slate-200 text-slate-600 text-[11px] font-medium py-1.5 px-3 rounded-md hover:bg-slate-50 transition cursor-pointer">
                    Annuler
                </button>
                <button type="submit" name='deleteUser' class="bg-rose-600 hover:bg-rose-700 text-white font-medium py-1.5 px-3 rounded-md text-[11px] transition shadow-xs cursor-pointer flex items-center gap-1.5">
                    <i class="fa-solid fa-trash-can text-[10px] opacity-80"></i> Confirmer
                </button>
            </div>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="module" src="../../public/js/modals.js"></script>
<script type="module" src="../../public/js/dashboard.js"></script>
</body>
</html>