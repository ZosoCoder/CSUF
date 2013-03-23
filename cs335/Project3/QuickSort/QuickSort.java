import java.util.Random;
import java.util.Scanner;
import java.io.*;

public class QuickSort {
	public static void main(String[] args) {
	/* Create and sort a random array of size provided using Quicksort */
		System.out.println("--Quick Sort--");
		int size = 1;
		
		try {
			size = Integer.parseInt(args[0]);
		} catch (NumberFormatException e) {
			System.out.println("The first argument must be an integer.");
			System.exit(1);
		}

		//Initialize array and random number generator
		int[] array = new int[size];
		Random generator = new Random(103);

		//Fill array with random ints
		for (int i=0; i<size; i++)
			array[i] = generator.nextInt(100);

		/* PRINT RANDOM ARRAY FOR TESTING
		System.out.print("\nUnsorted: ");
		PrintArray(array);
		*/

		//Set start time
		long start = System.nanoTime();

		//Sort array using quicksort
		QuickSortA(array,0,size-1);

		//Get elapsed time
		long elapsed = System.nanoTime() - start;

		/* PRINT ARRAY FOR TESTING
		System.out.print("\nSorted: ");
		PrintArray(array);
		*/
		System.out.format("\nQuicksort time %.2f milliseconds.\n",(elapsed/1000000.0));
	}

	public static void QuickSortA(int[] array, int l, int r) {
	/* Recursive sorting algorithm. Sorts array in place. */
		if (l < r) {
			int s = Partition(array,l,r);
			QuickSortA(array,l,s-1);
			QuickSortA(array,s+1,r);
		}
	}

	public static int Partition(int[] array, int l, int r) {
	/* Takes in an array and returns a chosen pivot */	
		Random generator = new Random();
		//Get a random number <r and >=l
		int s = generator.nextInt(r-l+1) + l;
		swap(array,l,s);
		int p = array[l];
		int i = l-1;
		int j = r+1;
		do {
			do {i++;} while (i<r && array[i] <= p);
			do {j--;} while (j>l && array[j] >= p);
			swap(array,i,j);
		}while (i<j);
		swap(array,i,j);
		swap(array,l,j);
		return j;
	}

	public static void swap(int[] a, int b, int c) {
	/* Takes in an array and swaps two values at indices b and c */
		int tmp = a[b];
		a[b] = a[c];
		a[c] = tmp;
	}

	public static void PrintArray(int[] a) {
	/* Prints array with space delimeters */
		for (int i=0; i<a.length; i++)
			System.out.print(a[i] + " ");
	}
}