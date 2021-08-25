<template>
	<el-row>
		<el-col :span="24">
			<el-card>
				<div slot="header">
					<template v-if="$route.params.id">
						{{ $t('route.product_edit') }}
					</template>
					<template v-else>
						{{ $t('route.product_create') }}
					</template>
				</div>
				<el-form ref="product" v-loading="loading.form" :model="form" :rules="rules" label-position="top">
				<el-row :gutter="20">
					<el-col :span="12">
						<el-form-item
						data-generator="name"
						:label="$t('table.product.name')"
						prop="name"
						:error="errors.name && errors.name[0]"
						>
							<el-input
								v-model="form.name"
								name="name"
								:placeholder="$t('table.product.name')"
								maxlength="191"
								show-word-limit
							/>
						</el-form-item>
					</el-col>
					<el-col :span="12">
						<el-form-item
						data-generator="code"
						:label="$t('table.product.code')"
						prop="code"
						:error="errors.code && errors.code[0]"
						>
							<el-input
								v-model="form.code"
								name="code"
								:placeholder="$t('table.product.code')"
								maxlength="191"
								show-word-limit
							/>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row :gutter="10">
					<el-col :span="6">
						<el-form-item
					data-generator="image"
					:label="$t('table.product.image')"
					prop="image"
					:error="errors.image && errors.image[0]"
					>
						<el-upload
						action="#"
						:auto-upload="false"
						list-type="picture-card"
						:on-change="onUploadImage"
						:file-list="formTmp.image"
						:on-remove="removeUploadImage"
						accept="image/png,image/jpeg,image/jpg"
						:class="{'hidden':formTmp.image.length > 0}"
							>
							<i
							class="el-icon-plus"
							></i>
						</el-upload>
					</el-form-item>
					</el-col>
					<el-col :span="6">
						<el-form-item
						data-generator="category_id"
						:label="$t('route.category')"
						prop="category_id"
						:error="errors.category_id && errors.category_id[0]"
						>
						<el-select
							v-model="form.category_id"
							name="category_id"
							filterable
							:placeholder="$t('route.category')"
							class="tw-w-full"
						>
							<el-option
							v-for="(item, index) in categoryList"
							:key="'category_' + index"
							:label="item.name"
							:value="item.id"
							/>
						</el-select>
						</el-form-item>
					</el-col>
				</el-row>
					<el-form-item
					data-generator="description"
					:label="$t('table.product.description')"
					prop="description"
					:error="errors.description && errors.description[0]"
					>
						<el-input
							v-model="form.description"
							name="description"
							type="textarea"
							:rows="5"
							:placeholder="$t('table.product.description')"
						/>
					</el-form-item>
					<el-row :gutter="10">
						<el-col :span="8">
							<el-form-item
								data-generator="stock_in"
								:label="$t('table.product.stock_in')"
								prop="stock_in"
								:error="errors.stock_in && errors.stock_in[0]"
							>
								<el-input-number
									v-model="form.stock_in"
									class="tw-w-full"
									name="stock_in"
									:placeholder="$t('table.product.stock_in')"
								/>
							</el-form-item>
						</el-col>
						<el-col :span="8">
							<el-form-item
								data-generator="price"
								:label="$t('table.product.price')"
								prop="price"
								:error="errors.price && errors.price[0]"
								>
								<div class="el-input el-input--medium">
									<money
									v-model="form.price"
									v-bind="money"
									:placeholder="$t('table.product.price')"
									class="el-input__inner"
									></money>
								</div>

							</el-form-item>
						</el-col>
						<el-col :span="8">
							<el-form-item
							data-generator="discount"
							:label="$t('table.product.discount')"
							prop="discount"
							:error="errors.discount && errors.discount[0]"
							>
								<el-input-number
									v-model="form.discount"
									class="tw-w-full"
									name="discount"
									:placeholder="$t('table.product.discount')"
								/>
							</el-form-item>
						</el-col>
					</el-row>
					<el-form-item
							data-generator="status"
							:label="$t('table.product.status')"
							prop="status"
							:error="errors.status && errors.status[0]"
							>
							<el-tooltip
								:content="form.status === 0 ? 'OFF' : 'ON'"
								placement="top"
							>
								<el-switch
									v-model="form.status"
									name="status"
									:active-value="1"
									:inactive-value="0"
								/>
							</el-tooltip>
					</el-form-item>
					<el-row v-for="(detail,indexDetail) in form.product_details" :key="indexDetail" class="product-detail__list" :gutter="10">
						<el-col :span="6">
							<el-form-item
							data-generator="size_id"
							:label="$t('route.size')"
							prop="size_id"
							:error="errors.size_id && errors.size_id[0]"
							>
								<el-select
									v-model="detail.size_id"
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
										v-model="detail.color_id"
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
								data-generator="amount"
								:label="$t('table.product_detail.amount')"
								prop="amount"
								:error="errors.amount && errors.amount[0]"
								>
									<el-input-number
									v-model="detail.amount"
									class="tw-w-full"
									name="amount"
									:placeholder="$t('table.product_detail.amount')"
							/>
							</el-form-item>
						</el-col>
						<el-col :span="6">
							<el-form-item
								data-generator="price"
								:label="$t('table.product_detail.price')"
								prop="price"
								:error="errors.price && errors.price[0]"
								>
									<el-input
									v-model="detail.price"
									name="price"
									:placeholder="$t('table.product_detail.price')"
									maxlength="191"
									show-word-limit
									/>
								</el-form-item>
						</el-col>
						<el-button
						v-show="form.product_details.length > 1"
						type="danger"
						class="product-detail__delete"
						icon="el-icon-delete"
						circle
						@click="onDeleteProductDetail(indexDetail)"
						></el-button>
					</el-row>
					<el-button icon="el-icon-plus" type="primary" @click="onAddProductDetail">Add product detail</el-button>

					<el-form-item class="tw-flex tw-justify-end">
						<router-link
							v-slot="{href,navigate}"
							:to="{name:'Product'}"
							custom
							>
							<a :href="href" class="el-button el-button--info is-plain" @click="navigate">{{ $t('button.cancel') }}</a>
						</router-link>
						<template v-if="$route.params.id">
							<el-button
								:loading="loading.button"
								type="primary"
								icon="el-icon-edit"
								@click="() => update('product')"
							>
								{{ $t('button.update') }}
							</el-button>
						</template>
						<template v-else>
							<el-button
								:loading="loading.button"
								type="success"
								icon="el-icon-plus"
								@click="() => store('product')"
							>
								{{ $t('button.create') }}
							</el-button>
						</template>
					</el-form-item>
				</el-form>
			</el-card>
		</el-col>
	</el-row>
</template>

<script>
import GlobalForm from '@/plugins/mixins/global-form';
import ProductResource from '@/api/v1/product';
import ColorResource from '@/api/v1/color';
import SizeResource from '@/api/v1/size';
import CategoryResource from '@/api/v1/category';
import Vue from 'vue';
import money from 'v-money';
Vue.use(money, { precision: 4 });

const productResource = new ProductResource();
const categoryResource = new CategoryResource();
const sizeResource = new SizeResource();
const colorResource = new ColorResource();

export default {
	mixins: [GlobalForm],
	data() {
		return {
			formTmp: {
				image: [],
			},
			formData: new FormData(),
			form: {
				id: '',
				name: '',
				image: '',
				description: '',
				stock_in: undefined,
				stock_out: 0,
				inventory: 0,

				discount: '',
				status: 1,
				code: '',

				category_id: '',
				product_details: [
					{
					price: '',
					color_id: '',
					size_id: '',
					amount: 0,
					},
				],
			},
			loading: {
				form: false,
				button: false,
			},
			money: {
				decimal: ',',
				thousands: '.',
				prefix: '',
				suffix: '',
				precision: 0,
				masked: false,
			},
			colorList: [],
			sizeList: [],
			categoryList: [],

		};
	},

	computed: {
		// not rename rules
		rules() {
			return {
				name: [
					{ required: true, message: this.$t('validation.required', { attribute: this.$t('table.product.name') }), trigger: ['change', 'blur'] },
				],
				code: [
					{ required: true, message: this.$t('validation.required', { attribute: this.$t('table.product.code') }), trigger: ['change', 'blur'] },
				],
				stock_in: [
					{ required: true, message: this.$t('validation.required', { attribute: this.$t('table.product.stock_in') }), trigger: ['change', 'blur'] },
				],
				price: [
					{ required: true, message: this.$t('validation.required', { attribute: this.$t('table.product.price') }), trigger: ['change', 'blur'] },
				],
				category_id: [
					{ required: true, message: this.$t('validation.required', { attribute: this.$t('route.category') }), trigger: ['change', 'blur'] },

				],

		// {{$RULES_NOT_DELETE_THIS_LINE$}}
			};
		},
	},
	async created() {
		try {
			this.loading.form = true;
			const { id } = this.$route.params;
			const { data: { data: color }} = await colorResource.getColor();
			this.colorList = color;
			const { data: { data: size }} = await sizeResource.getSize();
			this.sizeList = size;
			const { data: { data: category }} = await categoryResource.getCategory();
			this.categoryList = category;
			if (id) {
				const { data: { data: product }} = await productResource.get(id);
				this.form = product;
				this.formTmp.image.push({ url: product.image });
			}
			this.loading.form = false;
		} catch (e) {
			this.loading.form = false;
		}
	},
	methods: {
		onDeleteProductDetail(indexDetail){
			this.form.product_details.splice(indexDetail, 1);
		},
		onAddProductDetail(){
			this.form.product_details.push({
				price: '',
				color_id: '',
				size_id: '',
				amount: 0,
				});
		},
		onUploadImage(file){
			this.formTmp.image.push({ url: file.url });
			this.formData.set('image', file.raw);
		},
		removeUploadImage(){
			this.formTmp.image = [];
			this.formData.set('image', '');
		},
		appendToFormData(){
			Object.keys(this.form).forEach(key => {
				if (key !== 'image'){
					if (key === 'product_details'){
						this.formData.set('product_details', JSON.stringify(this.form.product_details));
					} else {
						this.formData.set(key, this.form[key]);
					}
				}
			});
		},
		store(product) {
			this.$refs[product].validate((valid, errors) => {
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
						this.appendToFormData();
						await productResource.store(this.formData);
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
		update(product) {
			this.$refs[product].validate((valid, errors) => {
				if (this.scrollToError(valid, errors)) {
					return;
				}
				this.$confirm(this.$t('common.popup.update'), {
					confirmButtonText: this.$t('button.update'),
					cancelButtonText: this.$t('button.cancel'),
					type: 'warning',
					center: true,
				}).then(async () => {
					try {
						this.loading.button = true;
						this.appendToFormData();
						this.formData.set('_method', 'PUT');
						await productResource.update(this.$route.params.id, this.formData);
						this.$message({
							showClose: true,
							message: this.$t('messages.update'),
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
	},
};
</script>
<style>
.hidden .el-upload{
	display: none !important;
}
.product-detail__list{
	position:
}
.product-detail__delete{
	position: absolute;
	top: 0;
	right: 0;
	display:none;
}
.product-detail__list:hover .product-detail__delete{
	display:block;
}
</style>
