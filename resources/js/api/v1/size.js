/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2021-08-17 12:25:08
 * File: Size.js
 */

import Resource from '@/api/resource';
import request from '@/utils/request';

export default class SizeResource extends Resource {
  constructor() {
    super('/sizes');
  }

  getSize() {
    return request({
      url: '/sizes/get-sizes',
      method: 'get',
    });
  }
  // {{$API_NOT_DELETE_THIS_LINE$}}
}
