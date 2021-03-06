<x-app>
<div class="container mt-4">
    <div class="border p-4">
        <h1 class="h4 mb-4 font-weight-bold">
            投稿の編集作成
        </h1>

        <form method="POST" action="{{ route('post.update', $post->id) }}">
            @csrf
            <!-- 疑似フォームメソッド。LaravelのRESTコントローラでは、updateはPATCH(PUT)が対応しているので、PUTにする。 -->
            @method('PUT')
            <fieldset class="mb-4">

                <div class="form-group">
                    <label for="subject">
                        カテゴリー
                    </label>

                    <select id="category_id" name="category_id"
                        class="form-control {{ $errors->has('category_id') ? 'is-invalid' : '' }}">
                        @foreach($categories as $id => $name)
                        <option value="{{ $id }}" @if ($post->category_id == $id)
                            selected
                            @endif
                            >
                            {{ $name }}
                        </option>
                        @endforeach
                    </select>

                </div>

                <div class="form-group">
                    <label for="subject">
                        お題
                    </label>
                    <input id="subject" name="subject"
                        class="form-control {{ $errors->has('subject') ? 'is-invalid' : '' }}"
                        value="{{ old('subject') ?: $post->subject }}" type="text">
                    @if ($errors->has('subject'))
                    <div class="invalid-feedback">
                        {{ $errors->first('subject') }}
                    </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="message">
                        3行で説明！！！
                    </label>

                    <!-- 1行目 -->

                    <div id="app1">
                        <input v-model="myText" id="body1" name="body1"
                            class="form-control {{ $errors->has('body1') ? 'is-invalid' : '' }}" rows="4" type="text">

                        @if ($errors->has('body1'))
                        <div class="invalid-feedback">
                            {{ $errors->first('body1') }}
                        </div>
                        @endif
                        <!-- @をつけないと、laravelのbladeの記述とかぶってしまって、エラーが出る。  -->
                        <p v-bind:style="{color: computedColor}">@{{ remaining }}/15文字</p>
                    </div>

                    <!-- 2行目 -->

                    <div id="app2">
                        <input v-model="myText" id="body2" name="body2"
                            class="form-control {{ $errors->has('body2') ? 'is-invalid' : '' }}" rows="4"
                            value="{{ old('body2') }}" type="text">
                        @if ($errors->has('body2'))
                        <div class="invalid-feedback">
                            {{ $errors->first('body2') }}
                        </div>
                        @endif
                        <!-- @をつけないと、laravelのbladeの記述とかぶってしまって、エラーが出る。  -->
                        <p v-bind:style="{color: computedColor}">@{{ remaining }}/15文字</p>

                    </div>

                    <!-- 3行目 -->

                    <div id="app3">
                        <input v-model="myText" id="body3" name="body3"
                            class="form-control {{ $errors->has('body3') ? 'is-invalid' : '' }}" rows="4"
                            value="{{ old('body3') }}" type="text">

                        @if ($errors->has('body3'))
                        <div class="invalid-feedback">
                            {{ $errors->first('body3') }}
                        </div>
                        @endif
                        <!-- @をつけないと、laravelのbladeの記述とかぶってしまって、エラーが出る。  -->
                        <p v-bind:style="{color: computedColor}">@{{ remaining }}/15文字</p>
                    </div>

                </div>

                <div class="mt-5">
                    <a class="btn btn-secondary" href="{{ route('post.index') }}">
                        キャンセル
                    </a>

                    <button type="submit" class="btn button_subColor">
                        編集する
                    </button>
                </div>
            </fieldset>
        </form>
    </div>
</div>
</x-app>