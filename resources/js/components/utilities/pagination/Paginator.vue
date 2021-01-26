<template>
    <!-- eslint-disable vue/no-use-v-if-with-v-for,vue/no-confusing-v-for-v-if -->
    <div>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li
                    class="page-item"
                    v-if="results.current_page > 2"
                    @click.prevent="$emit('get-page', 1)"
                >
                    <a class="page-link" href="#"
                        ><i class="fas fa-chevron-left"></i
                        ><i class="fas fa-chevron-left"></i
                    ></a>
                </li>
                <li
                    class="page-item"
                    v-if="results.current_page > 1"
                    @click.prevent="$emit('get-page', results.current_page - 1)"
                >
                    <a class="page-link" href="#"
                        ><i class="fas fa-chevron-left"></i
                    ></a>
                </li>
                <!-- Before Number -->

                <li class="page-item" v-if="results.current_page > 5">
                    <span class="page-link">
                        ...
                    </span>
                </li>

                <li
                    class="page-item"
                    v-for="num in results.last_page"
                    v-bind:key="num.last_page"
                    @click.prevent="$emit('get-page', num)"
                    v-if="
                        num > results.current_page - 5 &&
                            num < results.current_page + 5
                    "
                    :class="{ active: num === results.current_page }"
                >
                    <span class="page-link"> {{ num }}</span>
                </li>

                <li
                    class="page-item"
                    v-if="results.current_page < results.last_age - 5"
                >
                    <span class="page-link">
                        ...
                    </span>
                </li>
                <!-- After Number -->

                <li
                    v-if="results.current_page < results.last_page"
                    class="page-item"
                    @click.prevent="$emit('get-page', results.current_page + 1)"
                >
                    <a class="page-link" href="#"
                        ><i class="fas fa-chevron-right"></i
                    ></a>
                </li>
                <li
                    v-if="results.current_page < results.last_page - 1"
                    class="page-item"
                    @click.prevent="$emit('get-page', results.last_page)"
                >
                    <a class="page-link" href="#"
                        ><i class="fas fa-chevron-right"></i
                        ><i class="fas fa-chevron-right"></i
                    ></a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
export default {
    mounted() {},
    props: ["results"]
};
</script>
