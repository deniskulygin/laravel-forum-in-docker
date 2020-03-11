<template>
    <button :class="classes" @click="subscribe">subscribe</button>
</template>

<script>
    export default {
        name: 'subscribe-button',
        props: ['active'],
        computed: {
            classes() {
                return ['btn', this.isActive ? 'btn-primary' : 'btn-default']
            }
        },
        data() {
            return {
                isActive: this.active
            }
        },
        methods: {
            subscribe() {
                const requestType = this.isActive ? 'delete' : 'post';
                axios[requestType](location.pathname + '/subscriptions');
                this.isActive = !this.isActive;
            }
        }
    }
</script>

