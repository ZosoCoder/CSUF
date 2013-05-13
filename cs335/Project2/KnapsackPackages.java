import java.io.*;
import java.util.Scanner;
import java.util.List;
import java.util.ArrayList;

public class KnapsackPackages {
	private static int sumSizes(List<Package> pkgs) {
		//Calculate the sum of sizes in the package list
		int sum = 0;
		for (Package pkg : pkgs)
			sum += pkg.getSize();
		return sum;
	}

	private static int sumVotes(List<Package> pkgs) {
		//Calculate the sum of votes in the package list
		int sum = 0;
		for (Package pkg : pkgs)
			sum += pkg.getVotes();
		return sum;
	}

	public static void main(String[] args) {
		Scanner input = new Scanner(System.in);
		//Get parameters for running algorithm
		System.out.print("Number of packages(<30): ");
		int size = input.nextInt();
		System.out.print("Total weight: ");
		int weight = input.nextInt();
		System.out.println();
		//Setup file reader
		BufferedReader reader = null;
		String strRead = "";
		//Create array of packages
		Package[] pkgs = new Package[size];
		//Create file reader
		try {
			reader = new BufferedReader(new FileReader("packages.txt"));
		} catch (FileNotFoundException e) {
			System.out.println("Error: " + e);
		}
		//Read the file and populate the array
		try {
			strRead = reader.readLine();
			int count = 0;
			while ((strRead = reader.readLine()) != null && count < size) {
				//Split line read from file at space delimiters int a token array
				String splitArray[] = strRead.split(" ");
				//Store data read from file into variables to use to contruct
				//a Package object.
				String pkgName = splitArray[0];
				int pkgVotes = Integer.parseInt(splitArray[1]);
				int pkgSize = Integer.parseInt(splitArray[2]);
				pkgs[count] = new Package(pkgName,pkgSize,pkgVotes);
				//Increment count to stop when the size n is reached
				count++;
			}
		} catch (IOException e) {
			System.out.println("Error: " + e);
		}
		//--Knapsack algorithm
		int i,j;
		List<Package> bestPkgs = null;
		//Get start time for timing the algorithm
		long start = System.currentTimeMillis();
		for (i=0; i<(1<<size); i++) {
			//Create new empty list
			List<Package> s = new ArrayList<Package>();
			for (j=0; j < size; j++) {
				if (((i >> j) & 1) == 1)
					s.add(pkgs[j]);
			}
			if ((sumSizes(s) <= weight) && ((bestPkgs == null) 
					|| (sumVotes(s) > sumVotes(bestPkgs)))) {
				bestPkgs = s;
			}
		}
		//Get current time to calculate algorithm's duration
		long end = System.currentTimeMillis();
		//Print out packages in bestPkgs and the test info
		System.out.println("--Packages--");
		for (Package pkg : bestPkgs) {
			System.out.format("%-5s: %-18s\t%-6s: %6d \t %-5s: %4d\n", 
						  	  "Name",pkg.getName(),
						  	  "Votes",pkg.getVotes(),
						  	  "Size",pkg.getSize());		
		}
		System.out.println("\n" + "--Run Stats--");
		System.out.format("%-11s: %4d  %-12s: %6d\n",
						  "Total Size", sumSizes(bestPkgs),
						  "Total Votes", sumVotes(bestPkgs));
		System.out.format("Elapsed time: %.2f seconds",(end-start)/1000.0);
	}
}