import { Component, OnInit } from '@angular/core';
import { Book } from '../../model/book';
import { Subscription } from 'rxjs';
import { GraphQLService } from '../../service/graph-ql/graph-ql.service';

@Component({
  selector: 'app-add-book',
  templateUrl: './add-book.component.html',
  styleUrls: ['./add-book.component.css']
})
export class AddBookComponent implements OnInit {

  public book: Book;
  private querySubscription: Subscription;

  constructor(private service: GraphQLService) {
    this.book = new Book();
  }

  ngOnInit() {}

  createBook() {
    this.querySubscription = this.service
      .createBook(this.book)
      .subscribe(console.log);
  }
}
