import { Injectable } from '@angular/core';
import { Apollo } from 'apollo-angular';
import gql from 'graphql-tag';

import { bookList } from './queries/book-list.query';
import { addBook } from './mutations/add-book.mutate';
import { Book } from '../../model/book';

@Injectable({
  providedIn: 'root'
})
export class GraphQLService {
  private apollo: Apollo;
  private data: any;

  constructor(apollo: Apollo) {
    this.apollo = apollo;
  }

  hello() {
    this.apollo.query({
      query: gql`{ hello }`
    })
    .subscribe(console.log);
  }

  bookList(page: Number, perPage: Number = 20) {
    return this.apollo
        .query({
          query: bookList(page, perPage),
        });
  }

  createBook(book: Book) {
    const mutation = addBook(book);
    return this.apollo.mutate(mutation);
  }
}
