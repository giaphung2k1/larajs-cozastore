<template>
	<el-row>
		<el-col :span="24">
			<el-card>
				<div slot="header">
					{{ $t('route.product_sold') }}

				</div>
				<el-form ref="productPayment" v-loading="loading.form" :model="form" :rules="rules" label-position="top">
					<el-row :gutter="10">
						<el-col :span="12">
							<el-form-item
							data-generator="member_id"
							:label="$t('route.member')"
							prop="member_id"
							:error="errors.member_id && errors.member_id[0]"
							>
								<el-select
									v-model="form.member_id"
									name="member_id"
									filterable
									remote
									reserve-keyword
									:remote-method="searchMember"
									:loading="loading.member"
									:placeholder="$t('route.member')"
									class="tw-w-full"
								>
									<el-option
										v-for="(item, index) in memberList"
										:key="'member_' + index"
										:label="item.name"
										:value="item.id"
									>
									<div class="tw-flex tw-justify-between">
										<p>{{ item.name }}</p>
										<p class="tw-text-gray-400">{{ item.code }}</p>
									</div>
									</el-option>
								</el-select>
							</el-form-item>
						</el-col>
						<el-col :span="12">
							<el-button type="success" icon="el-icon-plus" style="margin-top:4.5rem" @click="memberVisible = true"></el-button>
						</el-col>
					</el-row>
					<el-row :gutter="10">
						<el-col :span="6">
							<el-form-item
							data-generator="size_id"
							:label="$t('route.size')"
							prop="size_id"
							:error="errors.size_id && errors.size_id[0]"
							>
								<el-select
									v-model="form.size_id"
									name="size_id"
									filterable
									:placeholder="$t('route.size')"
									class="tw-w-full"
								>
									<el-option
									v-for="(item, index) in sizeList"
									:key="'size_' + index"
									:label="item.name"
									:value="item.id"
								/>
								</el-select>
							</el-form-item>
						</el-col>

						<el-col :span="6">
							<el-form-item
								data-generator="color_id"
								:label="$t('route.color')"
								prop="color_id"
								:error="errors.color_id && errors.color_id[0]"
								>
									<el-select
										v-model="form.color_id"
										name="color_id"
										filterable
										:placeholder="$t('route.color')"
										class="tw-w-full"
									>
										<el-option
										v-for="(item, index) in colorList"
										:key="'color_' + index"
										:label="item.name"
										:value="item.id"
									/>
									</el-select>
							</el-form-item>
						</el-col>
						<el-col :span="6">
							<el-form-item
								data-generator="total"
								:label="$t('table.product_payment.total')"
								prop="total"
								:error="errors.total && errors.total[0]"
								>
									<el-input-number
										v-model="form.total"
										:min="1"
										name="total"
										:placeholder="$t('table.product_payment.total')"
									/>
								</el-form-item>
						</el-col>
						<el-col :span="24">
							<el-form-item
								data-generator="note"
								:label="$t('table.product_payment.note')"
								prop="note"
								:error="errors.note && errors.note[0]"
								>
									<el-input
										v-model="form.note"
										name="note"
										type="textarea"
										:rows="5"
										:placeholder="$t('table.product_payment.note')"
									/>
								</el-form-item>
						</el-col>
						<el-col :span="24">
							<el-form-item class="tw-flex tw-justify-end">
								<el-button
									:loading="loading.button"
									type="success"
									icon="el-icon-plus"
									@click="() => store('productPayment')"
								>
									{{ $t('button.create') }}
								</el-button>
							</el-form-item>
						</el-col>
					</el-row>
				</el-form>
			</el-card>
		</el-col>
		<el-form ref="member" v-loading="loading.member" :model="memberForm" :rules="memberRules" label-position="top">
			<el-dialog
			:title="$t('route.member_create')"
			:visible.sync="memberVisible"
			width="30%"
			center
			>
				<el-row :gutter="10">
					<el-col :span="24">
						<el-form-item
							data-generator="name"
							:label="$t('table.member.name')"
							prop="name"
							:error="errors.name && errors.name[0]"
							>
								<el-input
								v-model="memberForm.name"
								name="name"
								:placeholder="$t('table.member.name')"
								maxlength="191"
								show-word-limit
								@change="changeNameMember"
								/>
							</el-form-item>
					</el-col>
					<el-col :span="12">
						<el-form-item
							data-generator="sns_link"
							:label="$t('table.member.sns_link')"
							prop="sns_link"
							:error="errors.sns_link && errors.sns_link[0]"
							>
								<el-input
								v-model="memberForm.sns_link"
								name="sns_link"
								:placeholder="$t('table.member.sns_link')"
								maxlength="191"
								show-word-limit
								/>
							</el-form-item>
					</el-col>
					<el-col :span="12">
						<el-form-item
							data-generator="phone"
							:label="$t('table.member.phone')"
							prop="phone"
							:error="errors.phone && errors.phone[0]"
							>
								<el-input
								v-model="memberForm.phone"
								v-mask="'####-###-###'"
								name="phone"
								:placeholder="$t('table.member.phone')"
								maxlength="191"
								show-word-limit
								/>
							</el-form-item>
					</el-col>
				</el-row>
				<span slot="footer" class="dialog-footer">
					<el-button @click="memberVisible = false">Cancel</el-button>
					<el-button type="primary" @click="storeMember('member')">{{ $t('route.member_create') }}</el-button>
				</span>
			</el-dialog>
		</el-form>
	</el-row>
</template>
<script>
import GlobalForm from '@/plugins/mixins/global-form';
import ProductPaymentResource from '@/api/v1/product-payment';
import ProductResource from '@/api/v1/product';
import MemberResource from '@/api/v1/member';
import { validURL } from '@/utils/validate';

import Vue from 'vue';
import VueMask from 'v-mask';
Vue.use(VueMask);

const productPaymentResource = new ProductPaymentResource();
const memberResource = new MemberResource();
const productResource = new ProductResource();
export default {
	mixins: [GlobalForm],
	data(){
		return {
			form: {
				id: '',
				note: '',
				total: 1,
				product_id: this.$route.params.id,
				size_id: '',
				color_id: '',
				member_id: '',

			},
			loading: {
				form: false,
				button: false,
				member: false,
			},
			memberForm: {
				name: '',
				sns_link: '',
				phone: '',
			},
			productList: [],
			sizeList: [],
			colorList: [],
			memberList: [],
			memberVisible: false,

		};
	},
	computed: {
	// not rename rules
		rules() {
			return {
				member_id: [
					{ required: true, message: this.$t('validation.required', { attribute: this.$t('route.member') }), trigger: ['change', 'blur'] },
				],
				total: [
				{ required: true, message: this.$t('validation.required', { attribute: this.$t('table.product_payment.total') }), trigger: ['change', 'blur'] },
				],
				product_id: [
				{ required: true, message: this.$t('validation.required', { attribute: this.$t('route.product') }), trigger: ['change', 'blur'] },
				],
				size_id: [
				{ required: true, message: this.$t('validation.required', { attribute: this.$t('route.size') }), trigger: ['change', 'blur'] },
				],
				color_id: [
				{ required: true, message: this.$t('validation.required', { attribute: this.$t('route.color') }), trigger: ['change', 'blur'] },
				],
				// {{$RULES_NOT_DELETE_THIS_LINE$}}
			};
		},
		memberRules(){
			const validateSNSLink = (rule, value, callback) => {
				if (value){
					if (validURL(value)){
						callback();
					} else {
						callback(new Error(this.$t('validation.url', { attribute: this.$t('table.member.sns_link') })));
					}
				} else {
					callback();
				}
			};
			return {
				name: [
					{ required: true, message: this.$t('validation.required', { attribute: this.$t('table.member.name') }), trigger: ['change', 'blur'] },
				],
				sns_link: [
					{
						validator: validateSNSLink,
						trigger: ['change', 'blur'],
					},
				],
			};
		},

	},
	async created() {
	try {
		this.loading.form = true;
		const { id } = this.$route.params;
		const { data: { data: productDetails }} = await productResource.detail(id);
		this.sizeList = productDetails.sizes;
		this.colorList = productDetails.colors;
		this.memberList = productDetails.members;
		if (id) {
		const { data: { data: productDetail }} = await ProductPaymentResource.get(id);
		this.form = productDetail;
		}
		this.loading.form = false;
	} catch (e) {
		this.loading.form = false;
	}
	},
	methods: {
		changeNameMember(){
			this.memberForm.code = this.memberForm.name;
		},
		async searchMember(query){
			try {
				if (query){
					this.loading.member = true;
					const { data: { data: member }} = await memberResource.search(query);
					this.memberList = member;
					this.loading.member = false;
				} else {
					this.memberList = [];
				}
			} catch (e) {
				this.loading.member = false;
			}
		},
		store(productPayment){
			this.$refs[productPayment].validate((valid, errors) => {
				if (this.scrollToError(valid, errors)) {
					return;
				}
				this.$confirm(this.$t('common.popup.create'), {
					confirmButtonText: this.$t('button.create'),
					cancelButtonText: this.$t('button.cancel'),
					type: 'warning',
					center: true,
				}).then(async () => {
					try {
						this.loading.button = true;
						await productPaymentResource.store(this.form);
						this.$message({
							showClose: true,
							message: this.$t('messages.create'),
							type: 'success',
						});
						this.loading.button = false;
						await this.$router.push({ name: 'Product' });
					} catch (e) {
						this.loading.button = false;
					}
				});
			});
		},
		storeMember(member) {
		this.$refs[member].validate((valid, errors) => {
			if (this.scrollToError(valid, errors)) {
			return;
			}
			this.memberVisible = false;
			this.$confirm(this.$t('common.popup.create'), {
			confirmButtonText: this.$t('button.create'),
			cancelButtonText: this.$t('button.cancel'),
			type: 'warning',
			center: true,
			}).then(async () => {
			try {
				this.loading.member = true;
				const { data: { data: member }} = await memberResource.store(this.memberForm);
				this.memberList.push(member);
				this.$message({
				showClose: true,
				message: this.$t('messages.create'),
				type: 'success',
				});
				this.loading.member = false;
			} catch (e) {
				this.loading.member = false;
			}
			});
		});
		},
	},
};
</script>
<style scoped>
.el-message-box__wrapper{
	z-index:99999 !important;
}
</style>
