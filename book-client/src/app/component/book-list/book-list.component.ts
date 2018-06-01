import { Component, OnInit } from '@angular/core';
import { Apollo } from 'apollo-angular';
import { Subscription } from 'rxjs';
import { GraphQLService } from '../../service/graph-ql/graph-ql.service';
import { Book } from '../../model/book';

@Component({
  selector: 'app-book-list',
  templateUrl: './book-list.component.html',
  styleUrls: ['./book-list.component.css']
})
export class BookListComponent implements OnInit {

  private loading: Boolean;
  private bookList: Book[];
  private querySubscription: Subscription;

  constructor(private service: GraphQLService) {
  }

  ngOnInit() {
    this.querySubscription  = this.service.bookList(1)
    .subscribe(({data, loading}) => {
        this.bookList = data['bookList'].map(item => new Book().populateWith(item));
        this.loading = loading;
      });
  }
}
