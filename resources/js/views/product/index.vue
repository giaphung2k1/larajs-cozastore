<template>
	<el-row>
		<el-col :span="24">
			<el-card>
				<div slot="header" class="tw-flex tw-items-center">
					<div class="tw-flex-grow tw-text-center">
						<el-badge :value="productCard.total" class="item">
							<el-button type="success" size="small" icon="el-icon-s-shop" @click="productCard.visible = true"></el-button>
						</el-badge>
					</div>
					<router-link v-slot="{ href, navigate }" v-permission="['create']" :to="{name: 'ProductCreate'}" custom>
						<a :href="href" class="pan-btn blue-btn" @click="navigate">
							<i class="el-icon-plus mr-2" />
							{{ $t('button.create') }}
						</a>
					</router-link>
				</div>
				<el-row :gutter="20" type="flex" justify="space-between" class="tw-mb-6 tw-flex-wrap">
					<el-col :xs="24" :sm="8" :md="8">
						<label>{{ $t('table.texts.filter') }}</label>
						<el-input
							v-model="table.listQuery.search"
							class="tw-w-full"
							:placeholder="$t('table.texts.filterPlaceholder')"
						/>
					</el-col>
					<el-col :xs="24" :sm="8" :md="8">
						<br />
						<el-date-picker
							v-model="table.listQuery.updated_at"
							class="tw-w-full"
							type="daterange"
							:start-placeholder="$t('date.start_date')"
							:end-placeholder="$t('date.end_date')"
							:picker-options="pickerOptions"
							@change="changeDateRangePicker"
						/>
					</el-col>
				</el-row>
				<el-row :gutter="20">
					<el-col :span="24" class="table-responsive">
						<el-table
							v-loading="table.loading"
							class="tw-w-full"
							:data="table.list"
							:default-sort="{ prop: table.listQuery.orderBy, order: table.listQuery.ascending }"
							border
							fit
							highlight-current-row
							@sort-change="sortChange"
						>
							<el-table-column type="expand">
								<template slot-scope="{ row }">
									<div v-for="detail in row.product_details" :key="detail.id" class="product-detail">
										<el-row :gutter="10" type="flex" align="middle">
											<el-col :span="2" class="tw-text-center">
												<el-checkbox v-model="productCard.value" :label="detail.id" @change="changeProductCart($event,detail)">{{ '' }}</el-checkbox>
											</el-col>
											<el-col :span="20">
												<p><b>{{ $t('route.color') }}</b>: {{ detail.color && detail.color.name }}</p>
												<p><b>{{ $t('route.size') }}</b>: {{ detail.size && detail.size.name }}</p>
												<p><b>{{ $t('table.product_detail.amount') }}</b>: {{ detail.amount }}</p>
												<p><b>{{ $t('table.product_detail.price') }}</b>: {{ detail.price |currency }}</p>
											</el-col>
										</el-row>
									</div>
								</template>
							</el-table-column>
							<el-table-column data-generator="name" prop="name" :label="$t('table.product.name')" align="left" header-align="center">
								<template slot-scope="{ row }">
									{{ row.name }}
								</template>
							</el-table-column>
							<el-table-column data-generator="image" prop="image" :label="$t('table.product.image')" align="left" header-align="center">
								<template slot-scope="{ row }">
									<el-image fit="cover" :src="row.image">
										<div slot="error" class="image-slot">
											<i class="el-icon-picture-outline"></i>
										</div>
									</el-image>
								</template>
							</el-table-column>
							<el-table-column data-generator="stock_in" prop="stock_in" :label="$t('table.product.stock_in')" align="center" header-align="center">
								<template slot-scope="{ row }">
									{{ row.stock_in }}
								</template>
							</el-table-column>
							<el-table-column data-generator="stock_out" prop="stock_out" :label="$t('table.product.stock_out')" align="center" header-align="center">
								<template slot-scope="{ row }">
									{{ row.stock_out }}
								</template>
							</el-table-column>
							<el-table-column data-generator="inventory" prop="inventory" :label="$t('table.product.inventory')" align="center" header-align="center">
								<template slot-scope="{ row }">
									{{ row.inventory }}
								</template>
							</el-table-column>
							<el-table-column data-generator="discount" prop="discount" :label="$t('table.product.discount')" align="center" header-align="center">
								<template slot-scope="{ row }">
									{{ row.discount }}
								</template>
							</el-table-column>
							<el-table-column data-generator="status" prop="status" :label="$t('table.product.status')" align="center" header-align="center">
								<template slot-scope="{ row }">
									<el-tag>{{ row.status === 0 ? 'false' : 'true' }}</el-tag>
								</template>
							</el-table-column>
							<el-table-column data-generator="code" prop="code" :label="$t('table.product.code')" align="left" header-align="center">
								<template slot-scope="{ row }">
									{{ row.code }}
								</template>
							</el-table-column>

						<el-table-column data-generator="category_id" prop="category_id" :label="$t('route.category')" align="left" header-align="center">
								<template v-if="row.category" slot-scope="{ row }">
									{{ row.category.name }}
								</template>
							</el-table-column>

							<el-table-column data-generator="updated_at" prop="updated_at" :label="$t('date.updated_at')" sortable="custom" align="center" header-align="center">
								<template slot-scope="{ row }">
									{{ row.updated_at | parseTime('{y}-{m}-{d} {h}:{i}') }}
								</template>
							</el-table-column>
							<el-table-column :label="$t('table.actions')" align="center" class-name="small-padding fixed-width">
								<template slot-scope="{ row }">
									<!-- <router-link v-if="row.inventory !== row.stock_in" v-permission="['edit']" :to="{name: 'ProductSold', params: {id: row.id}}"><svg-icon class="tw-inline tw-mr-2" icon-class="sold-out" /></router-link> -->
									<router-link v-permission="['edit']" :to="{name: 'ProductEdit', params: {id: row.id}}"><i class="el-icon-edit el-link el-link--primary tw-mr-2" /></router-link>
									<a v-permission="['delete']" class="cursor-pointer" @click.stop="() => remove(row.id)"><i class="el-icon-delete el-link el-link--danger" /></a>
								</template>
							</el-table-column>
						</el-table>
						<pagination v-if="table.total > 0" :total="table.total" :page.sync="table.listQuery.page" :limit.sync="table.listQuery.limit" @pagination="getList" />
					</el-col>
				</el-row>
			</el-card>
		</el-col>
		<el-dialog
			:title="$t('route.product')"
			:visible.sync="productCard.visible"
			width="60%"
			@close="productCard.visible = false"
>
			<el-row v-for="detail in productCard.list" :key="detail.id" :gutter="10" class="tw-mb-8 tw-border-b-2">
				<el-col :span="4">
					<el-image fit="cover" :src="detail.image">
						<div slot="error" class="image-slot">
							<i class="el-icon-picture-outline"></i>
						</div>
					</el-image>
				</el-col>
				<el-col :span="4">
					<strong class="tw-text-center tw-block">{{ detail.name }}</strong>
					<p class="tw-text-center">{{ detail.size.name }}</p>
					<p class="tw-text-center">{{ detail.color.name }}</p>
					<p></p>
				</el-col>
				<el-col :span="4">{{ detail.category }}</el-col>
				<el-col :span="4">{{ detail.price | currency }}</el-col>
				<el-col :span="4">
					<el-input-number v-model="detail.amount" :min="1" :max="detail.amount"></el-input-number>
				</el-col>
				<el-col :span="4" class="tw-text-right">
					 <el-button type="danger" icon="el-icon-delete" circle @click="onDeleteProductCard(detail.id)"></el-button>
				</el-col>

			</el-row>
			<span slot="footer" class="dialog-footer">
				<el-button @click="productCard.visible = false">{{ $t('button.cancel') }}</el-button>
				<el-button type="primary" @click="productCard.visible = false">{{ $t('button.confirm') }}</el-button>
			</span>
		</el-dialog>
	</el-row>
</template>
<script>
	import DateRangePicker from '@/plugins/mixins/date-range-picker';
	import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination
	import { debounce } from '@/utils';
	import ProductsResource from '@/api/v1/product';
	const productResource = new ProductsResource();

	export default {
		components: { Pagination },
		filters: {
			currency(price){
				return Number((parseInt(price)).toFixed(1)).toLocaleString() + ' VNĐ';
			},
		},
		mixins: [DateRangePicker],
		data() {
			return {
				table: {
					listQuery: {
						search: '',
						limit: 25,
						ascending: 'descending',
						page: 1,
						orderBy: 'updated_at',
						updated_at: [],
					},
					list: null,
					total: 0,
					loading: false,
				},
				productCard: {
					value: [],
					total: 0,
					list: [],
					visible: false,
				},
			};
		},
		watch: {
			'table.listQuery.search': debounce(function () {
				this.handleFilter();
			}, 500),
		},

		created() {
			this.getList();
		},
		methods: {
			onDeleteProductCard(id){
				const index = this.productCard.list.findIndex(item => item.id === id);
				this.productCard.list.splice(index, 1);
				this.productCard.value = this.productCard.value.filter(value => value !== id);
				this.productCard.total = this.productCard.value.length;
			},
			changeProductCart(value, detail){
				this.productCard.total = this.productCard.value.length;
				if (value){
					const product = this.table.list.find(item => item.id === detail.product_id);

					this.productCard.list.push({ ...detail, category: product.category.name, name: product.name, image: product.image });
					console.log(detail);
				} else {
					const index = this.productCard.list.findIndex(item => item.id === detail.id);
					this.productCard.list.splice(index, 1);
				}
			},
			async getList() {
				try {
					this.table.loading = true;
					const { data } = await productResource.list(this.table.listQuery);
					this.table.list = data.data;
					this.table.total = data.count;
					this.table.loading = false;
				} catch (e) {
					this.table.loading = false;
				}
			},
			handleFilter() {
				this.table.listQuery.page = 1;
				this.getList();
			},
			changeDateRangePicker(date) {
				if (date) {
					const startDate = this.parseTimeToTz(date[0]);
					const endDate = this.parseTimeToTz(date[1]);
					this.table.listQuery.updated_at = [startDate, endDate];
				} else {
					this.table.listQuery.updated_at = [];
				}
				this.handleFilter();
			},
			sortChange(data) {
				const { prop, order } = data;
				this.table.listQuery.orderBy = prop;
				this.table.listQuery.ascending = order;
				this.getList();
			},
			remove(id) {
				this.$confirm(this.$t('messages.delete_confirm', { attribute: this.$t('table.product.id') + '#' + id }), this.$t('messages.warning'), {
					confirmButtonText: this.$t('button.ok'),
					cancelButtonClass: this.$t('button.cancel'),
					type: 'warning',
					center: true,
				}).then(async () => {
					try {
						this.table.loading = true;
						await productResource.destroy(id);
						const index = this.table.list.findIndex(value => value.id === id);
						this.table.list.splice(index, 1);
						this.$message({
							showClose: true,
							message: this.$t('messages.delete'),
							type: 'success',
						});
						this.table.loading = false;
					} catch (e) {
						this.table.loading = false;
					}
				});
			},
		},
	};
</script>
<style scoped>
.product-detail:not(:last-child){
	border-bottom: 1px solid darkgray;
	padding-bottom:0.5rem;
	margin-bottom:0.5rem;
}
</style>
