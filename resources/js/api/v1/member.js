/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2021-08-17 12:35:43
 * File: Member.js
 */

import Resource from '@/api/resource';
import request from '@/utils/request';

export default class MemberResource extends Resource {
  constructor() {
    super('/members');
  }

  search(search){
    return request({
      url: '/members/search',
      method: 'get',
      params: {
        search,
      },
    });
  }
  getMember() {
    return request({
      url: '/members/get-members',
      method: 'get',
    });
  }
  // {{$API_NOT_DELETE_THIS_LINE$}}
}
