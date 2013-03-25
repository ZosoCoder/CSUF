import java.util.Random;
import java.util.Scanner;

public class OptimalBS {
	public static void main(String[] args) {
		//Ask user for array size
		System.out.println("--Bubble Sort--");
		System.out.print("Size n of the array (int): ");
		Scanner input = new Scanner(System.in);
		int size = input.nextInt();

		//Initialize array and random number generator
		int[] array = new int[size];
		Random generator = new Random(481516);

		//Fill array with random ints
		for (int i=0; i<size; i++)
			array[i] = generator.nextInt(100);

		//Set start time
		long start = System.nanoTime();

		//Bubble sort
		boolean swapped;
		int n = size;
		int i,tmp;
		do {
			swapped = false;
			for (i=1; i<n; i++) {
				if (array[i-1] > array[i]) {
					tmp = array[i];
					array[i] = array[i-1];
					array[i-1] = tmp;
					swapped = true;
				}
			}
			--n;
		} while(swapped);

		//Get elapsed time
		long elapsed = System.nanoTime() - start;
		//printArray(array);
		//System.out.println();
		System.out.format("\nBubble Sort time: %.2f milliseconds.\n",(elapsed/1000000.0));
	}

	public static void printArray(int[] a) {
		for (int i=0; i<a.length; i++)
			System.out.print(a[i] + " ");
	}
}