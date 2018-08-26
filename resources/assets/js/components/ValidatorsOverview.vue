<template>
    <div class="candidatesOverviewContent">
        <table class="overviewTable">
            <thead>
            <tr>
                <th>&nbsp;</th>
                <th>Name</th>
                <th>Site</th>
                <th>Public Key</th>
                <th>Status</th>
                <th>Stake</th>
                <th>Commission</th>
                <th>Accumulated Reward</th>
                <th>Blocks Missed</th>
                <th>Delegates</th>
                <th>Created</th>
                <!--<th>Profile</th>-->
            </tr>
            </thead>
            <tbody>
            <tr v-for="(validator, index) in validators">
                <td class="delegateIndex">{{ index + 1 }}</td>
                <td>-</td>
                <td>-</td>
                <td :title="validator.public_key">{{ publicKeyShort(validator.public_key) }}</td>
                <td><i :class="getStatusIconClass(validator.status)"></i>&nbsp;{{ getStatus(validator.status) }}</td>
                <td>{{ convert(validator.stake_total, 2) }}</td>
                <td>{{ validator.commission }}</td>
                <td v-if="validator.status === 2">{{ convert(validator.reward_accumulated, 2) }} MNT</td>
                <td v-else>-</td>
                <td v-if="validator.status === 2">{{ validator.blocks_missed }}</td>
                <td v-else>-</td>
                <td>{{ validator.delegates }}</td>
                <td>{{ moment.unix(validator.declared_at_time).fromNow() }}</td>
                <!--<td><a href="javascript:void(0);" @click="showProfile(validator)">Profile</a></td>-->
            </tr>
            </tbody>
        </table>

        <!--
        <modal name="profile" @before-open="beforeProfileOpen">
            <p>132313</p>
        </modal>
        -->
    </div>
</template>

<script>
    export default {
        name: "validatorsOverview",

        data() {
            return {
                validators: {}
            }
        },

        methods: {

            publicKeyShort: function (publicKey) {
                return publicKey.substring(0, 5) + ".." + publicKey.substring(publicKey.length - 5);
            },

            getStatus: function (statusCode) {
                if (statusCode === 2) {
                    return "Active";
                } else if (statusCode === 1) {
                    return "Candidate";
                } else {
                    return "Unknown status";
                }
            },

            getStatusIconClass: function (statusCode) {
                if (statusCode === 2) {
                    return "fas fa-circle statusActiveValidator";
                } else if (statusCode === 1) {
                    return "fas fa-circle statusCandidate";
                } else {
                    return "Unknown status";
                }
            },

            convert: function (bip, precision = 18) {
                return _.round(bip / 1000000000000000000, precision);
            },

            update: function () {
                axios.get('api/validators')
                    .then(response => {
                        this.validators = response.data;
                    });
            },

            showProfile (validator) {
                this.$modal.show('profile', validator);
            },

            beforeProfileOpen (event) {
                console.log(event.params.validator);
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