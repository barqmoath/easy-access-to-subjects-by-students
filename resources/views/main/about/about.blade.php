@extends('layouts.app')
@section('title','About EASS')

@section('content')
<div class="container text-center" style="margin-top:10px;">
  <h1 style="font-size:6rem;font-weight:100;">EASS <span style="font-size:2rem;font-weight:100;">Easy Access To Subjects By Students</span> </h1>
  <h3 style="color:#607D8B;">Barq Moath Software Developer <i class="fa fa-copyright"></i> 2019</h3>
</div>

<div class="container" style="min-height:100vh;">
  <div class="contain">
    <div class="item item-1"></div>
    <div class="item item-2"></div>
    <div class="item item-3"></div>
    <div class="item item-4"></div>
  </div>
</div>
@stop

@section('css')
<style media="screen">
.contain {
  position: absolute;
  width: 200px;
  height: 200px;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  margin: auto;
  margin-top:280px;
}

.item {
width: 100px;
height: 100px;
position: absolute;
border-radius: 50%;
}

.item-1 {
background-color: #f44336;
top: 0;
left: 0;
z-index: 1;
animation: item-1_move 1.8s cubic-bezier(.6,.01,.4,1) infinite;
}

.item-2 {
background-color: #4CAF50;
top: 0;
right: 0;
animation: item-2_move 1.8s cubic-bezier(.6,.01,.4,1) infinite;
}

.item-3 {
background-color: #3f51b5;
bottom: 0;
right: 0;
z-index: 1;
animation: item-3_move 1.8s cubic-bezier(.6,.01,.4,1) infinite;
}

.item-4 {
background-color: #FAC24C;
bottom: 0;
left: 0;
animation: item-4_move 1.8s cubic-bezier(.6,.01,.4,1) infinite;
}

@keyframes item-1_move {
0%, 100% {transform: translate(0, 0)}
25% {transform: translate(0, 100px)}
50% {transform: translate(100px, 100px)}
75% {transform: translate(100px, 0)}
}

@keyframes item-2_move {
0%, 100% {transform: translate(0, 0)}
25% {transform: translate(-100px, 0)}
50% {transform: translate(-100px, 100px)}
75% {transform: translate(0, 100px)}
}

@keyframes item-3_move {
0%, 100% {transform: translate(0, 0)}
25% {transform: translate(0, -100px)}
50% {transform: translate(-100px, -100px)}
75% {transform: translate(-100px, 0)}
}

@keyframes item-4_move {
0%, 100% {transform: translate(0, 0)}
25% {transform: translate(100px, 0)}
50% {transform: translate(100px, -100px)}
75% {transform: translate(0, -100px)}
}
</style>
@stop
