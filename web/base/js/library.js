"use strict";

/**
 * Définition des contrôleurs
 */
var routeAppControllers = angular.module('routeAppControllers', []);

/**
 * Déclaration de l'application demoApp
 * En deuxième argument, les dépendances du module dans un tableau
 * Le config sert à changer les {{ }} d'Angular pour éviter les conflits avec TWIG
 */
var libraryApp = angular.module('libraryApp', ['libraryList', 'ngRoute', 'routeAppControllers']).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});

libraryApp.config(['$routeProvider', function($routeProvider) { 
    // Système de routage
    $routeProvider
    .when('/home', {
        templateUrl: 'accueil.html.twig',
        controller: 'homeCtrl'
    })
    .when('/contact', {
        templateUrl: 'library.html.twig',
        controller: 'libraryController'
    })
    .otherwise({
        redirectTo: 'accueil.html.twig'
    });
}
]);

/**
 * Déclaration du module libraryList
 */
var libraryList = angular.module('libraryList',[]);
var routeAppControllers = angular.module('routeAppControllers', [])

/**
 * Contrôleur de l'application "Todo List" décrite dans le chapitre "La logique d'AngularJS".
 */
libraryList.controller('libraryController', ['$scope',
    function ($scope) {
        // Pour manipuler plus simplement les livres au sein du contrôleur
        // On initialise la library avec un tableau vide : []
        var library = $scope.library = [];
        
        // Vide les champs du formulaire
        $scope.resetFields = function () {
        	// Réinitialisation de la variable newTodo
            $scope.newBookTitle = '';
            $scope.newBookAuthor = '';
        };
        
        // Ajouter un livre
        $scope.addBook = function () {
            // .trim() permet de supprimer les espaces inutiles
            // en début et fin d'une chaîne de caractères
            var newBookTitle = $scope.newBookTitle.trim();
            var newBookAuthor = $scope.newBookAuthor.trim();
            if (!newBookTitle.length) {
                // éviter les livres vides
                return;
            }
            library.push({
                // on ajoute le todo au tableau des todos
                title: newBookTitle,
                author: newBookAuthor,
                completed: false
            });
            // Réinitialisation de la variable newTodo
            $scope.newBookTitle = '';
            $scope.newBookAuthor = '';
        };

        // Enlever un livre
        $scope.removeBook = function (book) {
            library.splice(library.indexOf(book), 1);
        };
        
        // Enlever un livre
        $scope.updateBook = function (book) {
            library.splice(library.indexOf(book), 1);
            $scope.newBookTitle = book.title;
            $scope.newBookAuthor = book.author;
        };

        // Cocher / Décocher tous les livres
        $scope.markAll = function (completed) {
            library.forEach(function (book) {
                book.completed = completed;
            });
        };

        // Enlever tous les livres cochés
        $scope.clearCompletedBooks = function () {
            $scope.library = library = library.filter(function (book) {
                return !book.completed;
            });
        };
    }
]);

//Contrôleur de la page d'accueil
routeAppControllers.controller('homeCtrl', ['$scope',
    function($scope){
        $scope.message = "Bienvenue sur la page d'accueil";
    }
]);