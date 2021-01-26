/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


Vue.component('example-component', require('./components/ExampleComponent.vue').default);

// bodyの文字数をリアルタイムで表示する。
// 3行分それぞれ書いたけど、まとめる方法があると思うんだよね。。。
// バリデーションの後、入力したデータがdata:{myText}:''で上書きされて消えてしまう。
// 対処法不明。

var app = new Vue({
    el: '#app1',
    data: {
        myText: ''
    },
    computed: {
        remaining: function () {
            return 15 - this.myText.length;
        },
        computedColor: function () {
            col = '#33a';
            if (this.remaining < 5) {
                col = '#3a3';
            }
            if (this.remaining < 1) {
                col = '#a33';
            }
            return col;
        }
    }
});

var app = new Vue({
    el: '#app2',
    data: {
        myText: ''
    },
    computed: {
        remaining: function () {
            return 15 - this.myText.length;
        },
        computedColor: function () {
            col = '#33a';
            if (this.remaining < 5) {
                col = '#3a3';
            }
            if (this.remaining < 1) {
                col = '#a33';
            }
            return col;
        }
    }
});

var app = new Vue({
    el: '#app3',
    data: {
        myText: ''
    },
    computed: {
        remaining: function () {
            return 15 - this.myText.length;
        },
        computedColor: function () {
            col = '#33a';
            if (this.remaining < 5) {
                col = '#3a3';
            }
            if (this.remaining < 1) {
                col = '#a33';
            }
            return col;
        }
    }
});