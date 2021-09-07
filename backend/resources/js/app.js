/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require("./bootstrap");
require("./fontawesome");

import "./bootstrap";
import Vue from "vue";
import ArticleLike from "./components/ArticleLike";

const app = new Vue({
    el: "#app",
    components: {
        ArticleLike
    }
});



var app1 = new Vue({
    el: "#app1",
    data: {
        myText: ""
    },
    computed: {
        remaining: function() {
            return 15 - this.myText.length;
        }
    }
});

var app2 = new Vue({
    el: "#app2",
    data: {
        myText: ""
    },
    computed: {
        remaining: function() {
            return 15 - this.myText.length;
        }
    }
});

var app3 = new Vue({
    el: "#app3",
    data: {
        myText: ""
    },
    computed: {
        remaining: function() {
            return 15 - this.myText.length;
        }
    }
});