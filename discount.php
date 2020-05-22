if(input.Discount != Null)
{
	input.Net_Amount = ifnull(input.Gross_Amount,0.0) - ifnull(input.Discount / 100,0.0) * ifnull(input.Gross_Amount,0.0);
}