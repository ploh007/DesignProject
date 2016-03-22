void drawFft(float [] x, int index)
{
  stroke(0);
  for(int i=0;i<64;i++)
  {
    line(i+600, 100+(200*index), i+600, (200*index)+100-(x[i])/32);
  }
}

void drawGraph(float [][] dataArray)
{
  color [] colors = {#FF0000, #00FF00, #0000FF}; 
  
  for(int i=499;i>=0;i--)
  {
    for(int j=0;j<3;j++)
    {     
      int index = (head - (500 - i));
      if(index < 0){
        index += 500;
      }
      stroke(colors[j]);
      line(i, 100 + 200*j - dataArray[j][index], i, 100 + 200*j);
    }
  }
}