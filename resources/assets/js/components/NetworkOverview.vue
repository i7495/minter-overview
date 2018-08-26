<template>
    <div class="networkOverviewContent">
        <div class="networkOverviewItem">
            <p class="title">Latest Block</p>
            <p class="value">{{ network.latest_block_height }}</p>
        </div>
        <div class="networkOverviewItem">
            <p class="title">Network</p>
            <p class="value small">{{ network.tm_status.node_info.network }}</p>
        </div>
        <div class="networkOverviewItem">
            <p class="title">Number of Validators</p>
            <p class="value">{{ countValidators() }}</p>
        </div>
        <div class="networkOverviewItem">
            <p class="title">Number of Candidates</p>
            <p class="value">{{ countCandidates() }}</p>
        </div>
    </div>
</template>

<script>
    export default {
        name: "NetworkOverview",

        data() {
            return {
                network: {},
                validators: {}
            }
        },

        methods: {
            countCandidates: function () {
                let candidates = this.validators.filter(function(item) {
                    return item.status === 1;
                });
                return candidates.length;
            },

            countValidators: function () {
                let validators = this.validators.filter(function(item) {
                    return item.status === 2;
                });
                return validators.length;
            },

            update: function () {
                axios.get('api/network')
                    .then(response => {
                        this.network = response.data.result;
                    });
                axios.get('api/validators')
                    .then(response => {
                        this.validators = response.data;
                    });
            },

            animate: function (ref, start, end) {
                this.$refs[ref].reset(start, end);
                this.$refs[ref].start();
            }

        },

        mounted: function () {
            this.update();

            setInterval(function () {
                this.update();
            }.bind(this), 2500);
        }
    }
</script>