import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { AppRoutingModule } from './app-routing.module';
import { HttpClientModule } from '@angular/common/http';

import { AppComponent } from './component/app.component';
import { ErrorComponent } from './component/error/error.component';
import { BookListComponent } from './component/book-list/book-list.component';

import { GraphQLService } from './service/graph-ql/graph-ql.service';

import { ApolloModule, Apollo, APOLLO_OPTIONS } from 'apollo-angular';
import { HttpLinkModule, HttpLink } from 'apollo-angular-link-http';
import { InMemoryCache } from 'apollo-cache-inmemory';
import { AddBookComponent } from './component/add-book/add-book.component';

export function createApollo(httpLink: HttpLink) {
  return {
    link: httpLink.create({uri: 'http://localhost:8000/'}),
    cache: new InMemoryCache()
  };
}

@NgModule({
  declarations: [
    AppComponent,
    ErrorComponent,
    BookListComponent,
    AddBookComponent,
  ],
  imports: [
    BrowserModule,
    FormsModule,
    HttpClientModule,
    AppRoutingModule,
    ApolloModule,
    HttpLinkModule,
    AppRoutingModule,
  ],
  providers: [
    GraphQLService,
    {
      provide: APOLLO_OPTIONS,
      useFactory: createApollo,
      deps: [HttpLink]
    }
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
