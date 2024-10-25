<?php

session_start();

?>

<? include "./template/navbar.php"; ?>
<main>
    <section class="page">
        <h1>Gestions des jeux</h1>
    </section>
    <section class="formulaire-games">
        <article class="img-article">
            <img src="./img/sonic.gif" alt="Sonic">
        </article>
        <article class="form-jeux">
            <form action="" method="POST" id="formajout" enctype="multipart/form-data">
                <h4>Ajouter un jeu</h4>
                <div class="container-global">
                    <div class="container-left">
                        <div class="container-titre">
                            <label for="titre">Titre :</label>
                            <input type="text" placeholder="Titre du jeu" name="game_title" id="title" required>
                        </div>

                        <div class="container-plateformes">
                            <!-- Bouton du dropdown -->
                            <button class="dropdown-btn" onclick="toggleDropdown()" type="button">--Choisir la plateforme--</button>
                            <!-- Contenu du dropdown avec checkboxes -->
                            <div class="list-plateformes">
                                <label><input type="checkbox" name="option1" value="">Playstation</label>
                                <label><input type="checkbox" name="option2" value="">Xbox</label>
                                <label><input type="checkbox" name="option3" value="">Switch</label>
                                <label><input type="checkbox" name="option4" value="">PC</label>
                            </div>
                        </div>

                        <div class="container-categories">
                            <label for="categorie">Catégorie :</label>
                            <select id="categorie" name="category" required>
                                <option value="">--Choisir la catégorie--</option>
                                <option value="">Action</option>
                                <option value="">Aventure</option>
                                <option value="">FPS</option>
                                <option value="">Simulation</option>
                                <option value="">MMORPG</option>
                                <option value="">Plateforme</option>
                                <option value="">RPG</option>
                                <option value="">Sport</option>
                                <option value="">Stratégie</option>
                            </select>
                        </div>
                        <div class="container-pegis">
                            <label for="pegis">Pegi :</label>
                            <select id="pegis" name="category" required>
                                <option value="">--Choisir le pegi--</option>
                                <option value="">PEGI 3</option>
                                <option value="">PEGI 7</option>
                                <option value="">PEGI 12</option>
                                <option value="">PEGI 16</option>
                                <option value="">PEGI 18</option>
                            </select>
                        </div>
                        <div class="container-trailer">
                            <label for="trailer">Trailer :</label>
                            <input type="text" placeholder="Lien du trailer" name="pegi_name" id="trailer" required>
                        </div>
                        <div class="container-description">
                            <label for="trailer">Description :</label>
                            <textarea name="trailer" id="trailer" placeholder="Description du jeu" required></textarea>
                        </div>
                        <div class="container-background">
                            <label class="uploadlabel" for="background" id="uploadLabel">Uploader le background</label>
                            <input type="file" id="background" name="pegi_icon" class="icon" placeholder="Icon du PEGI" accept="image/*" required>
                            <img id="previewImage" src="#" alt="Aperçu de l'image" style="max-width: 100%; display: none;">
                            <button type="button" id="deleteImageButton" style="display: none;">Supprimer</button>
                        </div>
                    </div>
                    <div class="container-right">
                        <div class="container-image">
                            <label class="uploadlabel" for="jacket" id="uploadLabel">Uploader la jaquette</label>
                            <input type="file" id="image" name="pegi_icon" class="icon" placeholder="Icon du PEGI" accept="image/*" required>
                            <img id="previewImage" src="#" alt="Aperçu de l'image" style="max-width: 100%; display: none;">
                            <button type="button" id="deleteImageButton" style="display: none;">Supprimer</button>
                        </div>
                        <div class="container-image">
                            <label class="uploadlabel" for="image" id="uploadLabel">Uploader image 1</label>
                            <input type="file" id="image" name="pegi_icon" class="icon" placeholder="Icon du PEGI" accept="image/*" required>
                            <img id="previewImage" src="#" alt="Aperçu de l'image" style="max-width: 100%; display: none;">
                            <button type="button" id="deleteImageButton" style="display: none;">Supprimer</button>
                        </div>
                        <div class="container-image">
                            <label class="uploadlabel" for="image" id="uploadLabel">Uploader image 2</label>
                            <input type="file" id="image" name="pegi_icon" class="icon" placeholder="Icon du PEGI" accept="image/*" required>
                            <img id="previewImage" src="#" alt="Aperçu de l'image" style="max-width: 100%; display: none;">
                            <button type="button" id="deleteImageButton" style="display: none;">Supprimer</button>
                        </div>
                        <div class="container-image">
                            <label class="uploadlabel" for="image" id="uploadLabel">Uploader image 3</label>
                            <input type="file" id="image" name="pegi_icon" class="icon" placeholder="Icon du PEGI" accept="image/*" required>
                            <img id="previewImage" src="#" alt="Aperçu de l'image" style="max-width: 100%; display: none;">
                            <button type="button" id="deleteImageButton" style="display: none;">Supprimer</button>
                        </div>
                        <div class="container-image">
                            <label class="uploadlabel" for="image" id="uploadLabel">Uploader image 4</label>
                            <input type="file" id="image" name="pegi_icon" class="icon" placeholder="Icon du PEGI" accept="image/*" required>
                            <img id="previewImage" src="#" alt="Aperçu de l'image" style="max-width: 100%; display: none;">
                            <button type="button" id="deleteImageButton" style="display: none;">Supprimer</button>
                        </div>
                    </div>
                </div>
                <button type="submit" class="send">Envoyer</button>
            </form>
        </article>
    </section>
    <section class="dashboard">
        <h2>Dashboard</h2>

        <div class="container-search">
            <img src="../img/logos/search.svg" alt="Search">
            <input type="search" name="search" id="search" placeholder="Cherchez un jeu...">
        </div>

        <table>
            <thead>
                <tr>
                    <th>Action</th>
                    <th>Titre</th>
                    <th>Admin</th>
                    <th><input type="checkbox"></th>
                </tr>
            </thead>
            <tbody>
                <tr data-page="1">
                    <td class="actions">
                        <a href="#" class="btn-edit">Modifier</a>
                        <a href="#" class="btn-delete">Supprimer</a>
                    </td>
                    <td>Nom</td>
                    <td>Oé le rat</td>
                    <td><label><input type="checkbox"></label></td>
                </tr>
            </tbody>
        </table>
        <button class="deleteall">Supprimer tout</button>
    </section>
</main>
</body>
<script src="./js/admin.js"></script>

</html>
</main>