<template>
    <div>
        <button type="button" class="btn m-0 p-1 shadow-none" :class="{'text-danger':this.isLikedBy}" @click="clickLike">
            <i class="fas fa-heart mr-1"/>
        </button>
        {{countLikes}}
    </div>
</template>

<script>
// show.blade.phpで、initial-is-liked-byに渡した値が、プロパティのinitialsLikedByに渡される。
export default {
    props: {
        initialIsLikedBy:{
            type:Boolean,
            default:false,
        },
        initialCountLikes: {
            type:Number,
            default:0
        },
        authorized: {
            type:Boolean,
            default:false
        },
        endpoint: {
            type:String
        }
    },
    // 親コンポーネント(show.blade.php)からpropsへ渡されたプロパティの値を子のコンポーネント側で変更することは推奨されていない。
    // そのため、isLikedByを定義して使用する。
    data() {
        return {
            isLikedBy:this.initialIsLikedBy,
            countLikes:this.initialCountLikes,
        }
    },
    methods: {
      clickLike() {
        if (!this.authorized) {
          alert('いいね機能はログイン中のみ使用できます')
          return
        }

        this.isLikedBy
          ? this.unlike()
          : this.like()

      },
      async like() {
        const response = await axios.put(this.endpoint)

        this.isLikedBy = true
        this.countLikes = response.data.countLikes
      },
      async unlike() {
        const response = await axios.delete(this.endpoint)

        this.isLikedBy = false
        this.countLikes = response.data.countLikes
      },
    },
}

</script>
