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
